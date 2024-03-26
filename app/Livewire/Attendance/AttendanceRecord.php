<?php

namespace App\Livewire\Attendance;

use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AttendanceRecord extends Component
{
    use MemberFilterTrait;

    public Event $event;

    public function mount($event)
    {
        $this->initFilter();
        $this->useMemberGroupFilter = false;
        $this->event = $event;
        $this->previousUrl = url()->previous();
    }

    public function render()
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return view('livewire.attendance.attendance-record', [
            'members' => $memberList,
            'displayListOrGroup' => request()->get('listGroup', 'group'),
        ])->layout('layouts.backend');
    }
}
