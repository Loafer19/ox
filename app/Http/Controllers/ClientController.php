<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreUpdateRequest;
use App\Models\Client;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::query()
            ->latest()
            ->paginate(10);

        return view('clients.index', [
            'clients' => $clients,
        ]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(ClientStoreUpdateRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return redirect()->route('clients.index')
            ->with('success', __('Client created successfully.'));
    }

    public function show(Client $client): View
    {
        $orders = $client->orders()
            ->with('status')
            ->byStatus(request()->get('status_id'))
            ->latest()
            ->paginate(10);

        $statuses = Status::query()
            ->select('id', 'name')
            ->get();

        return view('clients.show', [
            'client' => $client,
            'orders' => $orders,
            'statuses' => $statuses,
        ]);
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', [
            'client' => $client,
        ]);
    }

    public function update(ClientStoreUpdateRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')
            ->with('success', __('Client updated successfully.'));
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->orders()->exists()) {
            return redirect()->route('clients.index')
                ->with('error', __('Client has orders.'));
        }

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', __('Client deleted successfully.'));
    }
}
