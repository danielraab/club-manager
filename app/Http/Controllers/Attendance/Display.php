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
        $cntIn = 0;
        $cntUnsure = 0;
        $cntOut = 0;
        $cntAttended = 0;
        $cntMembers = Member::allActive()->count();

        $attendances = $event->attendances()->get();

        $memberGroupCntList = [];

        foreach ($attendances as $attendance) {
            /** @var Attendance $attendance */
            if($attendance->poll_status === "in") $cntIn++;
            if($attendance->poll_status === "unsure") $cntUnsure++;
            if($attendance->poll_status === "out") $cntOut++;
            if($attendance->attended === true) $cntAttended++;

            foreach($attendance->member()->first()->memberGroups()->get() as $memberGroup) {
                $groupElem = $memberGroupCntList[$memberGroup->id] ?? [
                    "in" => 0,
                    "unsure" => 0,
                    "out" => 0,
                ];
                if($attendance->poll_status === "in") $groupElem["in"] = $groupElem["in"] + 1;
                if($attendance->poll_status === "unsure") $groupElem["unsure"] = $groupElem["unsure"] + 1;
                if($attendance->poll_status === "out") $groupElem["out"] = $groupElem["out"] + 1;
                $memberGroupCntList[$memberGroup->id] = $groupElem;
            }
        }

        return view('attendance.display', [
                "event" => $event,
                "memberGroupCntList" => $memberGroupCntList,
                "statistics" => [
                    "in" => $cntIn,
                    "unsure" => $cntUnsure,
                    "out" => $cntOut,
                    "unset" => $cntMembers - $cntIn - $cntUnsure - $cntOut,
                    "attended" => $cntAttended
                ]
            ]
        );
    }
}
