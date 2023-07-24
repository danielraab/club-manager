<?php

namespace App\Http\Livewire\Attendance;

use App\Http\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AttendanceRecord extends Component
{
    use MemberFilterTrait;

    public Event $event;
    public bool $displayMemberGroups = false;

    public function mount($event)
    {
        $this->event = $event;
        $this->previousUrl = url()->previous();
    }

    public function render()
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return view('livewire.attendance.attendance-record', ['members' => $memberList])->layout('layouts.backend');
    }
}
