<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Order;
use App\Observers\ClientObserver;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Client::observe(ClientObserver::class);
        Order::observe(OrderObserver::class);
    }
}
