<?php

namespace App\Console;

use App\Models\Event;
use App\Models\Filter\EventFilter;
use App\Notifications\UpcomingEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\WebPush\PushSubscription;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tomorrowMorning = now()->addDay()->setTime(0, 0);
            $tomorrowNight = now()->addDay()->setTime(23, 59, 59);

            $events = Event::getAllFiltered(
                new EventFilter($tomorrowMorning, $tomorrowNight, true, false, false)
            )->get();

            if ($events->count() > 0) {
                foreach ($events as $event) {
                    Notification::send(
                        PushSubscription::all(),
                        new UpcomingEvent($event)
                    );
                }
            }
        })
            ->name('event web push notifications (tomorrow events)')
            ->dailyAt('15:00'); // timezone UTC

        $schedule->call(function () {
            $events = Event::getAllFiltered(new EventFilter(
                now()->addHours(2)->setMinute(0)->setSecond(0),
                now()->addHours(2)->setMinute(59)->setSecond(59),
                true,
                false,
                false
            ))->get();

            if ($events->count() > 0) {
                foreach ($events as $event) {
                    Notification::send(
                        PushSubscription::all(),
                        new UpcomingEvent($event)
                    );
                }
            }
        })
            ->name('event web push notifications 2 hours before start')
            ->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
