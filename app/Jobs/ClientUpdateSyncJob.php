<?php

namespace App\Jobs;

use App\Models\Client;
use App\Services\KeyCRMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientUpdateSyncJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Client $client) {}

    public function handle(): void
    {
        if (is_null($this->client->external_id)) {
            (new KeyCRMService())
                ->createClient($this->client);
        } else {
            (new KeyCRMService())
                ->updateClient($this->client);
        }
    }
}
