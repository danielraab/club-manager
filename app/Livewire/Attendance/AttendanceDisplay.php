<?php

namespace App\Livewire\Attendance;

use App\Calculation\AttendanceStatistic;
use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use Livewire\Component;

class AttendanceDisplay extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $attendanceStatistic = new AttendanceStatistic($this->event);
        $attendanceStatistic->calculateStatistics();

        return view('livewire.attendance.attendance-display', [
            'statistic' => $attendanceStatistic
        ])->layout('layouts.backend');
    }
}
