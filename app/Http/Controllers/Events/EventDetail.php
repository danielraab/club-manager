<?php

namespace App\Http\Controllers\Events;


use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventDetail extends Controller
{

    public function index(Event $event)
    {
        if (auth()->guest() &&
            (!$event->enabled || $event->logged_in_only)) {
            throw new ModelNotFoundException();
        }
        return view("events.event-detail", ["event" => $event]);
    }
}
