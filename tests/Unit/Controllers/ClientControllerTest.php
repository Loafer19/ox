<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Bus::fake();
});

it('can show clients', function () {
    $response = $this->get(route('clients.index'));

    $response->assertStatus(200)
        ->assertViewIs('clients.index')
        ->assertViewHas('clients')
        ->assertSee('Clients');
});

it('can show create page', function () {
    $response = $this->get(route('clients.create'));

    $response->assertStatus(200)
        ->assertViewIs('clients.create');
});

it('can store client', function () {
    $client = Client::factory()->make()->toArray();

    $response = $this->post(route('clients.store'), $client);

    $response->assertRedirect(route('clients.index'))
        ->assertSessionHas('success', __('Client created successfully.'));

    $this->assertDatabaseHas('clients', $client);
});

it('can show client page with orders', function () {
    $client = Client::factory()
        ->hasOrders(3)
        ->create();

    $response = $this->get(route('clients.show', $client));

    $response->assertStatus(200)
        ->assertViewIs('clients.show')
        ->assertViewHas('client', $client);
});

it('can show edit page', function () {
    $client = Client::factory()->create();

    $response = $this->get(route('clients.edit', $client));

    $response->assertStatus(200)
        ->assertViewIs('clients.edit')
        ->assertViewHas('client', $client);
});

it('can update client', function () {
    $client = Client::factory()->create();
    $newClient = Client::factory()->make()->toArray();

    $response = $this->put(route('clients.update', $client), $newClient);

    $response->assertRedirect(route('clients.index'))
        ->assertSessionHas('success', __('Client updated successfully.'));

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'name' => $newClient['name'],
    ]);
});

it('can destroy client', function () {
    $client = Client::factory()->create();

    $response = $this->delete(route('clients.destroy', $client));

    $response->assertRedirect(route('clients.index'))
        ->assertSessionHas('success', __('Client deleted successfully.'));

    $this->assertDatabaseMissing('clients', [
        'id' => $client->id,
    ]);
});

it("can't destroy client with orders", function () {
    $client = Client::factory()
        ->hasOrders(1)
        ->create();

    $response = $this->delete(route('clients.destroy', $client));

    $response->assertRedirect(route('clients.index'))
        ->assertSessionHas('error', __('Client has orders.'));

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
    ]);
});
