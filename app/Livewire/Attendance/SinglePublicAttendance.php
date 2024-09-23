<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance as AttendanceModel;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SinglePublicAttendance extends Component
{
    public Event $event;

    public Member $member;

    public function mount($event, $member)
    {
        $this->event = $event;
        $this->member = $member;
    }

    public function recordPoll(?string $result)
    {
        $attendance = $this->event->attendances()->where('member_id', $this->member->id)->first();

        if ($attendance === null) {
            $attendance = new AttendanceModel;
            $attendance->event_id = $this->event->id;
            $attendance->member_id = $this->member->id;
        }

        $attendance->poll_status = $result;
        $attendance->save();
        Log::info('Attendance record set', [auth()->user(), $attendance]);
        $this->dispatch("attendance-updated.{$this->event->id}.{$this->member->id}");
    }

    public function render()
    {
        return view('livewire.attendance.single-public-attendance');
    }
}
