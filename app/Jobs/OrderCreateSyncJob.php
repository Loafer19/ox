<?php

namespace App\Jobs;

use App\Contracts\CRM;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderCreateSyncJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function handle(CRM $crm): void
    {
        $crm->createOrder($this->order);
    }
}
