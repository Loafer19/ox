<?php

namespace App\Observers;

use App\Jobs\OrderCreateSyncJob;
use App\Jobs\OrderUpdateSyncJob;
use App\Models\Order;

class OrderObserver
{
    public function created(Order $order): void
    {
        OrderCreateSyncJob::dispatch($order);
    }

    public function updated(Order $order): void
    {
        OrderUpdateSyncJob::dispatch($order);
    }
}
