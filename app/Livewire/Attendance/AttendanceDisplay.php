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
        $attendanceStatistics = $this->event->getAttendanceStatistics($this->getMemberFilter());

        return view('livewire.attendance.attendance-display', [
                'statistics' => $attendanceStatistics,
            ]
        )->layout('layouts.backend');
    }
}
