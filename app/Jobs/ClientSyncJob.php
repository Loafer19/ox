<?php

namespace App\Jobs;

use App\Models\Client;
use App\Services\KeyCRMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientSyncJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $page = 1;
        $last_page = 1;

        while ($page <= $last_page) {
            $response = (new KeyCRMService())->getClients($page);

            $raw = [];
            foreach ($response['data'] as $client) {
                $raw[] = [
                    'external_id' => $client['id'],
                    'name' => $client['full_name'],
                    'synced_at' => now(),
                ];
            }

            Client::upsert($raw, ['external_id'], ['name', 'synced_at']);

            $last_page = $response['last_page'];
            $page++;
        }
    }
}
