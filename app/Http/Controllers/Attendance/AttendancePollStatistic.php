<?php

declare(strict_types=1);

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\Event;
use Illuminate\Support\Arr;

class AttendancePollStatistic extends Controller
{
    public AttendancePoll $attendancePoll;

    public function render(AttendancePoll $attendancePoll)
    {
        $this->attendancePoll = $attendancePoll;

        return view('attendance.poll-statistic', [
            'attendancePoll' => $attendancePoll,
            'memberStatistic' => Arr::sortDesc($this->createMemberStatistic()),
        ]);
    }

    private function createMemberStatistic(): array
    {
        $memberList = [];

        foreach ($this->attendancePoll->events()->get() as $event) {
            /** @var $event Event */
            foreach ($event->attendances()->get() as $attendance) {
                /** @var $attendance Attendance */
                if ($attendance->attended) {
                    $memberId = $attendance->member()->first()->id;
                    if (! isset($memberList[$memberId])) {
                        $memberList[$memberId] = 0;
                    }

                    $memberList[$memberId] = $memberList[$memberId] + 1;
                }
            }
        }

        return $memberList;
    }
}
