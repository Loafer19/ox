<?php

use App\Contracts\CRM;
use App\DTO\ClientDTO;
use App\DTO\OrderDTO;
use App\Jobs\OrderSyncJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('handles order synchronization', function () {
    $this->seed();
    Queue::fake();

    $crmMock = mock(CRM::class);
    $crmMock->shouldReceive('getOrders')
        ->andReturn([
            'items' => [
                new OrderDTO(1, new ClientDTO(1, 'Client 1', now()->toDateTimeString()), 'Order 1', now()->toDateTimeString()),
                new OrderDTO(2, new ClientDTO(2, 'Client 2', now()->toDateTimeString()), 'Order 2', now()->toDateTimeString()),
            ],
            'last_page' => 1,
        ]);

    $job = new OrderSyncJob();
    $job->handle($crmMock);

    $this->assertDatabaseHas('clients', ['external_id' => 1, 'name' => 'Client 1']);
    $this->assertDatabaseHas('clients', ['external_id' => 2, 'name' => 'Client 2']);

    $this->assertDatabaseHas('orders', ['external_id' => 1, 'comment' => 'Order 1']);
    $this->assertDatabaseHas('orders', ['external_id' => 2, 'comment' => 'Order 2']);
});
