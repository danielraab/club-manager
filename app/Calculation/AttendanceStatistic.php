<?php

namespace App\Calculation;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Filter\MemberFilter;

class AttendanceStatistic
{
    private Event $event;

    private ?MemberFilter $memberFilter;

    public function __construct(Event $event, MemberFilter $memberFilter = null)
    {
        $this->event = $event;
        $this->memberFilter = $memberFilter;
        if ($this->memberFilter === null) {
            $this->memberFilter = new \App\Models\Filter\MemberFilter(true, true, true);
        }
    }

    public function getAttendanceStatistics(): array
    {
        $cntIn = 0;
        $cntUnsure = 0;
        $cntOut = 0;
        $cntAttended = 0;

        $attendances = $this->event->attendances()->get();

        $memberGroupCntList = [];

        foreach ($attendances as $attendance) {
            /** @var Attendance $attendance */
            if (! $attendance->member()->first()?->matchFilter($this->memberFilter)) {
                continue;
            }

            if ($attendance->poll_status === 'in') {
                $cntIn++;
            }
            if ($attendance->poll_status === 'unsure') {
                $cntUnsure++;
            }
            if ($attendance->poll_status === 'out') {
                $cntOut++;
            }
            if ($attendance->attended === true) {
                $cntAttended++;
            }

            foreach ($attendance->member()->first()->memberGroups()->get() as $memberGroup) {
                $groupElem = $memberGroupCntList[$memberGroup->id] ?? [
                    'in' => 0,
                    'unsure' => 0,
                    'out' => 0,
                    'attended' => 0,
                ];
                if ($attendance->poll_status === 'in') {
                    $groupElem['in'] = $groupElem['in'] + 1;
                }
                if ($attendance->poll_status === 'unsure') {
                    $groupElem['unsure'] = $groupElem['unsure'] + 1;
                }
                if ($attendance->poll_status === 'out') {
                    $groupElem['out'] = $groupElem['out'] + 1;
                }
                if ($attendance->attended) {
                    $groupElem['attended'] = $groupElem['attended'] + 1;
                }
                $memberGroupCntList[$memberGroup->id] = $groupElem;
            }
        }

        return [
            'in' => $cntIn,
            'unsure' => $cntUnsure,
            'out' => $cntOut,
            'attended' => $cntAttended,
            'memberGroupStatistics' => $memberGroupCntList,
            'unset' => $attendances->count() - ($cntIn + $cntUnsure + $cntOut),
        ];
    }
}
