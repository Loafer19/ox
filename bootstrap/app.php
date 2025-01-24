<?php

use App\Jobs\ClientSyncJob;
use App\Jobs\OrderSyncJob;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
    )
    ->withMiddleware()
    ->withExceptions()
    ->withSchedule(function ($schedule) {
        $schedule
            ->job(new ClientSyncJob)
            ->hourlyAt(5);
        $schedule
            ->job(new OrderSyncJob)
            ->hourlyAt(15);
    })
    ->create();
