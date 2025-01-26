<?php

namespace App\Jobs;

use App\Contracts\CRM;
use App\Models\Client;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderSyncJob implements ShouldQueue
{
    use Queueable;

    public function handle(CRM $crm): void
    {
        $page = 1;
        $last_page = 1;
        $status_id = Status::first()->id;

        while ($page <= $last_page) {
            $response = $crm->getOrders($page);

            $raw = [];

            foreach ($response['items'] as $orderDTO) {
                $client = Client::firstOrCreate([
                    'external_id' => $orderDTO->clientDTO->external_id,
                ], [
                    'name' => $orderDTO->clientDTO->name,
                ]);

                $raw[] = [
                    'external_id' => $orderDTO->external_id,
                    'status_id' => $status_id,
                    'client_id' => $client->id,
                    'comment' => $orderDTO->comment,
                    'synced_at' => now(),
                ];
            }

            Order::upsert($raw, ['external_id'], ['comment', 'synced_at']);

            $last_page = $response['last_page'];
            $page++;
        }
    }
}
