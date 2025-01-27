<?php

use App\Contracts\CRM;
use App\DTO\ClientDTO;
use App\Jobs\ClientSyncJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('handles client synchronization', function () {
    Queue::fake();

    $crmMock = mock(CRM::class);
    $crmMock->shouldReceive('getClients')
        ->andReturn([
            'items' => [
                new ClientDTO(1, 'Client 1', now()->toDateTimeString()),
                new ClientDTO(2, 'Client 2', now()->toDateTimeString()),
            ],
            'last_page' => 1,
        ]);

    $job = new ClientSyncJob();
    $job->handle($crmMock);

    $this->assertDatabaseHas('clients', ['external_id' => 1, 'name' => 'Client 1']);
    $this->assertDatabaseHas('clients', ['external_id' => 2, 'name' => 'Client 2']);
});
