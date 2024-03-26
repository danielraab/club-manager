<?php

namespace App\Livewire\Attendance;

use App\Calculation\AttendanceStatistic;
use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use Livewire\Component;

class AttendanceDisplay extends Component
{
    use MemberFilterTrait;

    public Event $event;

    public function mount(Event $event)
    {
        $this->initFilter();
        $this->useMemberGroupFilter = false;
        $this->event = $event;
    }

    public function render()
    {
        $attendanceStatistics = new AttendanceStatistic($this->event, $this->getMemberFilter());

        return view('livewire.attendance.attendance-display', [
            'statistics' => $attendanceStatistics->getAttendanceStatistics(),
            'displayListOrGroup' => request()->get('listGroup', 'group'),
        ])->layout('layouts.backend');
    }
}
