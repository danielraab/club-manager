<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;

class Display extends Controller
{

    public function index(Event $event)
    {
        $cntMembers = Member::allActive()->count();
        $cntIn = $event->attendances()->where('poll_status', 'in')->count();
        $cntUnsure = $event->attendances()->where('poll_status', 'unsure')->count();
        $cntOut = $event->attendances()->where('poll_status', 'in')->count();

        return view('attendance.display', [
                "event" => $event,
                "statistics" => [
                    "in" => $cntIn,
                    "unsure" => $cntUnsure,
                    "out" => $cntOut,
                    "unset" => $cntMembers - $cntIn - $cntUnsure - $cntOut,
                    "attended" => 0
                ]
            ]
        );
    }
}
