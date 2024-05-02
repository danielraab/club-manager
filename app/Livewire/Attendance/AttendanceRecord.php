<?php

namespace App\Livewire\Attendance;

use App\Facade\NotificationMessage;
use App\Livewire\MemberFilterTrait;
use App\Models\Event;
use App\Models\Member;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
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

    public function removeAllAttendanceRecords(): void
    {
        $this->event->attendances()->delete();
        $this->dispatch('all-attendance-updated');
        Log::info('All attendance records of this event deleted', [auth()->user(), $this->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('All attendance records of this event were successfully deleted.'), ItemType::WARNING));
    }

    public function render()
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return view('livewire.attendance.attendance-record', [
            'members' => $memberList,
        ])->layout('layouts.backend');
    }
}
