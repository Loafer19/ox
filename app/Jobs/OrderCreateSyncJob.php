<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\KeyCRMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderCreateSyncJob implements ShouldQueue
{
    use Queueable;

    // we can inject the order id to avoid serialization
    public function __construct(public Order $order) {}

    public function handle(): void
    {
        (new KeyCRMService())
            ->createOrder($this->order);
    }
}
