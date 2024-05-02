<?php

namespace App\Livewire\Attendance;

use App\Calculation\AttendanceStatistic;
use App\Models\Event;
use Livewire\Attributes\Session;
use Livewire\Component;

class AttendanceDisplay extends Component
{
    public Event $event;

    #[Session]
    public bool $showUnattended = true;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $attendanceStatistic = new AttendanceStatistic($this->event);
        $attendanceStatistic->calculateStatistics();

        return view('livewire.attendance.attendance-display', [
            'statistic' => $attendanceStatistic,
        ])->layout('layouts.backend');
    }
}
