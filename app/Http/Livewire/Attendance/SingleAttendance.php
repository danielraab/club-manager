<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Attendance as AttendanceModel;
use App\Models\Event;
use App\Models\Member;
use Livewire\Component;

class SingleAttendance extends Component
{
    public Event $event;
    public Member $member;

    public function mount($event, $member)
    {
        $this->event = $event;
        $this->member = $member;
    }

    public function recordPoll(?string $result) {
        $attendance = $this->event->attendances()->where("member_id", $this->member->id)->first();

        if($attendance === null) {
            $attendance = new AttendanceModel();
            $attendance->event_id = $this->event->id;
            $attendance->member_id = $this->member->id;
        }

        $attendance->poll_status = $result;
        $attendance->save();
    }

    public function recordAttend(?bool $attend) {
        $attendance = $this->event->attendances()->where("member_id", $this->member->id)->first();

        if($attendance === null) {
            $attendance = new AttendanceModel();
            $attendance->event_id = $this->event->id;
            $attendance->member_id = $this->member->id;
        }

        $attendance->attended = $attend;
        $attendance->save();
    }

    public function render()
    {
        return view('components.livewire.attendance.single-attendance');
    }
}
