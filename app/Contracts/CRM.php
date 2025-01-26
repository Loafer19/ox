<?php

namespace App\Contracts;

use App\DTO\ClientDTO;
use App\DTO\OrderDTO;
use App\Models\Client;
use App\Models\Order;

interface CRM
{
    /**
     * @return array{last_page: int, items: array<int, ClientDTO>}
     */
    public function getClients(int $page): array;

    public function createClient(Client $client): void;

    public function updateClient(Client $client): void;

    /**
     * posible to split into separate interface
     *
     * @return array{last_page: int, items: array<int, OrderDTO>}
     */
    public function getOrders(int $page): array;

    public function createOrder(Order $order): void;

    public function updateOrder(Order $order): void;
}
