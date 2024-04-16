<?php

namespace App\Livewire\Attendance;

use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use Livewire\Attributes\Session;
use Livewire\Component;

class AttendanceRecord extends Component
{
    use MemberFilterTrait;

    public Event $event;

    #[Session]
    public bool $isDisplayGroup = true;

    public function mount($event)
    {
        $this->initFilter();
        $this->useMemberGroupFilter = false;
        $this->event = $event;
    }

    public function render()
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return view('livewire.attendance.attendance-record', [
            'members' => $memberList
        ])->layout('layouts.backend');
    }
}
