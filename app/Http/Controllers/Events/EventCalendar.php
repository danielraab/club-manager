<?php

declare(strict_types=1);

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;

class EventCalendar extends Controller
{

    public function render()
    {
        $jsonEventList = "[]";


        $eventList = \App\Models\Event::getAllFiltered(
            new \App\Models\EventFilter(true, false, !auth()->guest())
        )
            ->get(["title", "start", "end", "whole_day", "description", "location", "dress_code"])
            ->map(function ($event) {
                if ($event["description"]) {
                    $event["description"] = str_replace("\n", "; ", $event["description"]);
                }
                $event["allDay"] = $event["whole_day"];
                unset($event["whole_day"]);
                return $event;
            });

        $jsonEventList = $eventList->toJson();

        return view('events.calendar', [
            "jsonEventList" => $jsonEventList
        ]);
    }
}
