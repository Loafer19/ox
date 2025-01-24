<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Order;
use App\Models\Status;
use App\Services\KeyCRMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderSyncJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $page = 1;
        $last_page = 1;
        $status_id = Status::first()->id;

        while ($page <= $last_page) {
            $response = (new KeyCRMService())->getOrders($page);

            $raw = [];
            foreach ($response['data'] as $order) {
                $client = Client::firstOrCreate([
                    'external_id' => $order['buyer']['id'],
                ], [
                    'name' => $order['buyer']['full_name'],
                ]);

                $raw[] = [
                    'external_id' => $order['id'],
                    'status_id' => $status_id,
                    'client_id' => $client->id,
                    'comment' => $order['buyer_comment'],
                    'synced_at' => now(),
                ];
            }

            Order::upsert($raw, ['external_id'], ['comment', 'synced_at']);

            $last_page = $response['last_page'];
            $page++;
        }
    }
}
