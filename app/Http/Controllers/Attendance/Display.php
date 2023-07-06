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

        return view('attendance.display', [
                "event" => $event,
                "memberList" => $this->getMemberAttendanceList($event)
            ]
        );
    }

    private function getMemberAttendanceList($event)
    {
        $memberList = [];

        $attendances = $event->attendances()->get();
        foreach ($attendances as $attendance) {
            /** @var Attendance $attendance */
            $memberList[] = [
                "member" => $attendance->member()->first(),
                "poll_status" => $attendance->poll_status,
                "final_status" => $attendance->final_status
            ];
        }

        return $memberList;
    }
}
