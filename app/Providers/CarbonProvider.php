<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class CarbonProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Carbon::macro('formatDateInput', function () {
            return Carbon::this()->setTimezone(config('app.displayed_timezone'))->format("Y-m-d");
        });
        Carbon::macro('formatDatetimeLocalInput', function () {
            return Carbon::this()->setTimezone(config('app.displayed_timezone'))->format("Y-m-d\TH:i");
        });

        Carbon::macro('parseFromDatetimeLocalInput', function ($dateTimeLocalInput) {
            return Carbon::parse($dateTimeLocalInput)->shiftTimezone(config('app.displayed_timezone'))->setTimezone('UTC');
        });

        Carbon::macro('formatDateOnly', function ($withDayName = false) {
            $time = Carbon::this()->setTimezone(config('app.displayed_timezone'));
            if($withDayName) {
                return $time->isoFormat("dd D. MMM YYYY");
            }
            return $time->isoFormat("D. MMM YYYY");
        });
        Carbon::macro('formatDateTimeWithSec', function () {
            return Carbon::this()->setTimezone(config('app.displayed_timezone'))->isoFormat('D. MMM YYYY - HH:mm:ss');
        });
    }
}
