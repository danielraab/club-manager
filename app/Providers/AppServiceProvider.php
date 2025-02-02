<?php

namespace App\Providers;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Authentik\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
            $appName = Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME, default: $appName);
        } catch (QueryException $qe) {
        }
        view()->share('appName', $appName);

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('authentik', Provider::class);
        });
    }
}
