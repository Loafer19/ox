<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Bus::fake();
});

it('can show orders', function () {
    $response = $this->get(route('orders.index'));

    $response->assertStatus(200)
        ->assertViewIs('orders.index')
        ->assertViewHas('orders')
        ->assertSee('Orders');
});

it('can show create page', function () {
    $response = $this->get(route('orders.create'));

    $response->assertStatus(200)
        ->assertViewIs('orders.create');
});

it('can store order', function () {
    $order = Order::factory()->make()->toArray();

    $response = $this->post(route('orders.store'), $order);

    $response->assertRedirect(route('orders.index'))
        ->assertSessionHas('success', __('Order created successfully.'));

    $this->assertDatabaseHas('orders', $order);
});

it('can show edit page', function () {
    $order = Order::factory()->create();

    $response = $this->get(route('orders.edit', $order));

    $response->assertStatus(200)
        ->assertViewIs('orders.edit')
        ->assertViewHas('order', $order);
});

it('can update order', function () {
    $order = Order::factory()->create();
    $newOrder = Order::factory()->make()->toArray();

    $response = $this->put(route('orders.update', $order), $newOrder);

    $response->assertRedirect(route('orders.index'))
        ->assertSessionHas('success', __('Order updated successfully.'));

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'client_id' => $newOrder['client_id'],
        'status_id' => $newOrder['status_id'],
        'comment' => $newOrder['comment'],
    ]);
});

it('can destroy order', function () {
    $order = Order::factory()->create();

    $response = $this->delete(route('orders.destroy', $order));

    $response->assertRedirect(route('orders.index'))
        ->assertSessionHas('success', __('Order deleted successfully.'));

    $this->assertDatabaseMissing('orders', [
        'id' => $order->id,
    ]);
});
