<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AttendanceRecord extends Component
{
    public Event $event;

    public bool $onlyActive = false;

    public bool $displayMemberGroups = false;

    public function mount($event)
    {
        $this->event = $event;
        $this->previousUrl = url()->previous();
    }

    public function render()
    {
        /** @var Builder $memberList */
        $memberList = Member::orderBy('lastname')->orderBy('firstname');

        if ($this->onlyActive) {
            $memberList = Member::allActive();
        }

        return view('livewire.attendance.attendance-record', ['members' => $memberList])->layout('layouts.backend');
    }
}
