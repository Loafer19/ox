<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;

class ClientOrderController extends Controller
{
    public function create(Client $client): View
    {
        return view('clients.orders.create', [
            'client' => $client,
        ]);
    }
}
