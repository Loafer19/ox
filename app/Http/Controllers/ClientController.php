<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreUpdateRequest;
use App\Models\Client;
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
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', __('Client deleted successfully.'));
    }
}
