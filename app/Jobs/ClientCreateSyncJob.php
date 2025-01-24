<?php

namespace App\Jobs;

use App\Models\Client;
use App\Services\KeyCRMService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClientCreateSyncJob implements ShouldQueue
{
    use Queueable;

    // we can inject the client id to avoid serialization
    public function __construct(public Client $client) {}

    public function handle(): void
    {
        (new KeyCRMService())
            ->createClient($this->client);
    }
}
