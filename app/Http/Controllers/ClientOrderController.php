<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientOrderController extends Controller
{
    public function create(Client $client): View
    {
        return view('clients.orders.create', [
            'client' => $client,
        ]);
    }

    public function destroy(Client $client, Order $order): RedirectResponse
    {
        app(OrderService::class)->delete($order);

        return redirect()->route('clients.show', $client);
    }
}
