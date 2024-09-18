<?php

namespace App\Providers;

use App\NotificationMessage\NotificationMessage;
use Illuminate\Support\ServiceProvider;

class NotificationMessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('notificationMessage', function () {
            return new NotificationMessage;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
