<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    public function delete(Order $order): void
    {
        Storage::disk('public')->delete($order->files ?? []);

        $order->delete();
    }
}
