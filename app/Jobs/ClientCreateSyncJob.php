<?php

namespace App\Jobs;

use App\Contracts\CRM;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientCreateSyncJob implements ShouldQueue
{
    use Queueable;

    // we can inject the client id to avoid serialization
    public function __construct(public Client $client) {}

    public function handle(CRM $crm): void
    {
        $crm->createClient($this->client);
    }
}
