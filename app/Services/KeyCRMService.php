<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KeyCRMService
{
    private readonly PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::withToken(config('services.keycrm.token'))
            ->baseUrl(config('services.keycrm.url'));
    }

    /**
     * @return array<string, mixed>
     */
    public function getClients(int $page): array
    {
        $response = $this->httpClient->get('/buyer', [
            'limit' => 50,
            'page' => $page,
        ]);

        if ($response->failed()) {
            Log::error('Failed to get clients', [
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to get clients');
        }

        return $response->json();
    }

    public function createClient(Client $client): void
    {
        $response = $this->httpClient->post('/buyer', [
            'full_name' => $client->name,
            'custom_fields' => [
                [
                    'uuid' => config('services.keycrm.buyer_field_id'),
                    'value' => $client->id,
                ],
            ],
        ]);

        if ($response->failed()) {
            Log::error('Failed to create client', [
                'client_id' => $client->id,
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to create client');
        }

        $client->updateQuietly([
            'external_id' => $response->json('id'),
            'synced_at' => now(),
        ]);
    }

    public function updateClient(Client $client): void
    {
        $response = $this->httpClient->put('/buyer/' . $client->external_id, [
            'full_name' => $client->name,
        ]);

        if ($response->failed()) {
            Log::error('Failed to update client', [
                'client_id' => $client->id,
                'external_id' => $client->external_id,
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to update client');
        }

        $client->updateQuietly([
            'synced_at' => now(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getOrders(int $page): array
    {
        $response = $this->httpClient->get('/order', [
            'limit' => 50,
            'page' => $page,
            'include' => 'buyer',
        ]);

        if ($response->failed()) {
            Log::error('Failed to get orders', [
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to get orders');
        }

        return $response->json();
    }

    public function createOrder(Order $order): void
    {
        $response = $this->httpClient->post('/order', [
            'source_id' => config('services.keycrm.source_id'),
            'buyer_comment' => $order->comment,
            'buyer' => [
                'id' => $order->client->external_id,
            ],
            'custom_fields' => [
                [
                    'uuid' => config('services.keycrm.order_field_id'),
                    'value' => $order->id,
                ],
            ],
        ]);

        if ($response->failed()) {
            Log::error('Failed to create order', [
                'order_id' => $order->id,
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to create order');
        }

        $order->updateQuietly([
            'external_id' => $response->json('id'),
            'synced_at' => now(),
        ]);
    }

    public function updateOrder(Order $order): void
    {
        $response = $this->httpClient->put('/order/' . $order->external_id, [
            'buyer_comment' => $order->comment,
        ]);

        if ($response->failed()) {
            Log::error('Failed to update order', [
                'order_id' => $order->id,
                'external_id' => $order->external_id,
                'response' => $response->json(),
            ]);

            throw new \Exception('Failed to update order');
        }

        $order->updateQuietly([
            'synced_at' => now(),
        ]);
    }
}
