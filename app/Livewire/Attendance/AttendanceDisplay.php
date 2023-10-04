<?php

namespace App\Livewire\Attendance;

use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use Livewire\Component;

class AttendanceDisplay extends Component
{
    use MemberFilterTrait;

    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $attendanceStatistics = $this->event->getAttendanceStatistics();
        $cntMembers = Member::getAllFiltered($this->getMemberFilter())->count();

        return view('livewire.attendance.attendance-display', [
                'statistics' => [
                    'unset' => $cntMembers - (
                            $attendanceStatistics['in'] +
                            $attendanceStatistics['unsure'] +
                            $attendanceStatistics['out']),
                    ...$attendanceStatistics,
                ],
            ]
        )->layout('layouts.backend');
    }
}
