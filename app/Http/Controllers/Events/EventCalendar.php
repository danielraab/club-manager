<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Livewire\Profile\CalendarLinks;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class EventCalendar extends Controller
{
    const CALENDAR_REFRESH_INTERVAL_MIN = 60 * 6;

    public function iCalendar(): \Illuminate\Http\Response
    {
        $calendar = Calendar::create(env('APP_NAME'))->refreshInterval(self::CALENDAR_REFRESH_INTERVAL_MIN);

        $authToken = false;
        $token = request()->get("t");
        if ($token && PersonalAccessToken::query()
                ->where("token", $token)
                ->where("name", CalendarLinks::CALENDAR_TOKEN_NAME)
                ->first()) {
            $authToken = true;

            //TODO add member birthdays
        }

        $this->addEventsToCalendar($calendar, auth()->user() || $authToken);

        return Response::make($calendar->get(), 200, [
            'Content-Type' => 'text/ics',
            'Content-Disposition' => 'attachment; filename="calendar.ics"',
        ]);
    }

    private function addEventsToCalendar(Calendar $calendar, $inclLoggedInOnly = false): void
    {
        foreach ($this->getEventList($inclLoggedInOnly) as $event) {
            /** @var Carbon $end */
            $calEvent = Event::create($event->title)
                ->startsAt($event->start);
            $end = $event->end;
            if ($event->description) {
                $calEvent->description($event->description);
            }
            if ($event->location) {
                $calEvent->address($event->location);
            }
            if ($event->whole_day) {
                $calEvent->fullDay();
                $end->addDay();
            }
            $calEvent->endsAt($end);
            $calendar->event($calEvent);
        }
    }

    private function getEventList($inclLoggedInOnly = false): Collection
    {
        $eventList = \App\Models\Event::query()->orderBy('start', 'desc');
        if (!$inclLoggedInOnly) {
            $eventList = $eventList->where('logged_in_only', false);
        }
        $eventList = $eventList->where('enabled', true);

        return $eventList->get(['id', 'title', 'description', 'whole_day', 'start', 'end', 'link', 'location', 'dress_code']);
    }
}
