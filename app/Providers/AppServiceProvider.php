<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('appName', \App\Models\Configuration::getString(\App\Models\ConfigurationKey::APPEARANCE_APP_NAME) ?: config('app.name'));
    }
}
