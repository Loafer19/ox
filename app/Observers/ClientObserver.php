<?php

namespace App\Observers;

use App\Jobs\ClientCreateSyncJob;
use App\Jobs\ClientUpdateSyncJob;
use App\Models\Client;

class ClientObserver
{
    public function created(Client $client): void
    {
        ClientCreateSyncJob::dispatch($client);
    }

    public function updated(Client $client): void
    {
        ClientUpdateSyncJob::dispatch($client);
    }
}
