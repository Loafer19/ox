<?php

namespace App\Jobs;

use App\Contracts\CRM;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientUpdateSyncJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Client $client) {}

    public function handle(CRM $crm): void
    {
        if (is_null($this->client->external_id)) {
            $crm->createClient($this->client);
        } else {
            $crm->updateClient($this->client);
        }
    }
}
