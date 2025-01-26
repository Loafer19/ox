<?php

namespace App\Providers;

use App\Contracts\CRM;
use App\Models\Client;
use App\Models\Order;
use App\Observers\ClientObserver;
use App\Observers\OrderObserver;
use App\Services\KeyCRMService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Client::observe(ClientObserver::class);
        Order::observe(OrderObserver::class);

        $this->app->singleton(CRM::class, fn () => new KeyCRMService());
    }
}
