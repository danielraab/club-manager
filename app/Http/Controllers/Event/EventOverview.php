<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventOverview extends Controller
{
    public function index()
    {
        $eventList = Event::orderBy('start', 'desc');
        if(Auth::guest()) {
            $eventList = $eventList->where("logged_in_only", false);
        } elseif(!Auth::user()->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $eventList = $eventList->where("enabled", true);
        }
        $eventList = $eventList->paginate(10);

        return view('events.event-overview', [
            'eventList' => $eventList
        ]);
    }
}
