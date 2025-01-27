<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Status;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(OrderIndexRequest $request): View
    {
        $orders = Order::query()
            ->with('client', 'status')
            ->byStatus($request->get('status_id'))
            ->latest()
            ->paginate(10);

        $statuses = Status::query()
            ->select('id', 'name')
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => $statuses,
        ]);
    }

    public function create(): View
    {
        $clients = Client::query()
            ->select('id', 'name')
            ->get();

        return view('orders.create', [
            'clients' => $clients,
        ]);
    }

    public function store(OrderStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['status_id'] = Status::first()->id;

        // can be moved to service
        if ($request->hasFile('files')) {
            $files = [];

            // @phpstan-ignore-next-line
            foreach ($request->file('files') as $file) {
                $files[] = $file->store('orders', 'public');
            }

            $data['files'] = $files;
        }

        Order::create($data);

        return redirect()->route('orders.index')
            ->with('success', __('Order created successfully.'));
    }

    public function edit(Order $order): View
    {
        $clients = Client::query()
            ->select('id', 'name')
            ->get();

        $statuses = Status::query()
            ->select('id', 'name')
            ->get();

        return view('orders.edit', [
            'order' => $order,
            'clients' => $clients,
            'statuses' => $statuses,
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')
            ->with('success', __('Order updated successfully.'));
    }

    public function destroy(Order $order): RedirectResponse
    {
        app(OrderService::class)->delete($order);

        return redirect()->route('orders.index')
            ->with('success', __('Order deleted successfully.'));
    }
}
