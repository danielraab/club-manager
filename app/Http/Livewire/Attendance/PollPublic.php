<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendancePoll;
use App\Models\Member;
use Livewire\Component;

class PollPublic extends Component
{
    public AttendancePoll $poll;
    public string $memberSelection = "";
    public Member|null $selectedMember = null;

    public function mount(string $attendancePoll)
    {
        dd(AttendancePoll::query()->find($attendancePoll)->where("enabled", true)->get()); //TODO
        $this->poll = AttendancePoll::query()->find($attendancePoll)->where("enabled", true)->firstOrFail();
    }


    public function render()
    {
        return view('livewire.attendance.poll-public')->layout('layouts.backend');
    }
}
