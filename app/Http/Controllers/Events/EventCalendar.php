<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class EventCalendar extends Controller
{
    public function toJson()
    {
        return $this->getEventList();
    }

    public function iCalendar()
    {
        return Response::make($this->getCsvString(), 200, [
            'Content-Type' => 'text/cvs',
            'Content-Disposition' => 'attachment; filename="calendar.csv"',
        ]);
    }

    private function getCsvString()
    {

        $calendar = Calendar::create(env('APP_NAME'));

        foreach ($this->getEventList() as $event) {
            $calEvent = Event::create($event->title)
                ->startsAt($event->start)
                ->endsAt($event->end);
            if ($event->description) {
                $calEvent->description($event->description);
            }
            if ($event->whole_day) {
                $calEvent->fullDay();
            }
            $calendar->event($calEvent);
        }

        return $calendar->get();
    }

    private function getEventList()
    {
        $eventList = \App\Models\Event::orderBy('start', 'desc');
        if (Auth::guest()) {
            $eventList = $eventList->where('logged_in_only', false);
        }
        $eventList = $eventList->where('enabled', true);

        return $eventList->get(["id", "title", "description", "whole_day", "start", "end", "link", "location", "dress_code"]);
    }
}
