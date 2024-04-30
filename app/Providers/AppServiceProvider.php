<?php

namespace App\Providers;

use Illuminate\Database\QueryException;
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
        $appName = config('app.name');
        try {
            $appName = \App\Models\Configuration::getString(\App\Models\ConfigurationKey::APPEARANCE_APP_NAME, default: $appName);
        } catch (QueryException $qe) {}
        view()->share('appName', $appName);
    }
}
