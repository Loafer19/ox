<?php

namespace App\Jobs;

use App\Contracts\CRM;
use App\Helpers\TransformToArray;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientSyncJob implements ShouldQueue
{
    use Queueable;

    public function handle(CRM $crm): void
    {
        $page = 1;
        $last_page = 1;

        while ($page <= $last_page) {
            // to avoid unnecessary requests/updates we can
            // add filter to api request to get only recently created/updated clients
            $response = $crm->getClients($page);

            $raw = array_map(new TransformToArray(), $response['items']);

            Client::upsert($raw, ['external_id'], ['name', 'synced_at']);

            $last_page = $response['last_page'];
            $page++;
        }
    }
}
