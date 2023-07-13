<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Member;

class Display extends Controller
{

    public function index(Event $event)
    {
        $attendanceStatistics = $event->getAttendanceStatistics();
        $cntMembers = Member::allActive()->count();

        return view('attendance.display', [
                "event" => $event,
                "statistics" => [
                    "unset" => $cntMembers - (
                        $attendanceStatistics["in"] +
                        $attendanceStatistics["unsure"] +
                        $attendanceStatistics["out"]),
                    ...$attendanceStatistics
                ]
            ]
        );
    }
}
