<?php

namespace App\Http\Livewire\Attendance;

use App\Http\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use Livewire\Component;

class AttendanceDisplay extends Component
{
    use MemberFilterTrait;

    public Event $event;
    public bool $displayMemberGroups = true;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $attendanceStatistics = $this->event->getAttendanceStatistics();
        $cntMembers = Member::getAllFiltered(
            !$this->filterShowBeforeEntrance,
            !$this->filterShowAfterRetired,
            !$this->filterShowPaused
        )->count();

        return view('livewire.attendance.attendance-display', [
                'statistics' => [
                    'unset' => $cntMembers - (
                            $attendanceStatistics['in'] +
                            $attendanceStatistics['unsure'] +
                            $attendanceStatistics['out']),
                    ...$attendanceStatistics,
                ],
            ]
        );
    }
}
