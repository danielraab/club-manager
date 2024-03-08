<?php

namespace App\Livewire\Attendance;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\PollForm;
use App\Models\AttendancePoll;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PollEdit extends Component
{
    public PollForm $pollForm;

    public string $previousUrl;

    public function mount(AttendancePoll $attendancePoll)
    {
        $this->pollForm->setModel($attendancePoll);
        $this->previousUrl = url()->previous();
    }

    public function savePoll()
    {
        $this->pollForm->update();

        Log::info("Poll edited", [auth()->user(), $this->pollForm->poll]);
        NotificationMessage::addNotificationMessage(
            new Item( __('The attendance poll has been successfully updated.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function addEventsToSelection($additionalEventIdList): void
    {
        $this->pollForm->addEventsToSelection($additionalEventIdList);
    }

    public function removeEventFromSelection($eventId): void
    {
        $this->pollForm->removeEventFromSelection($eventId);
    }

    public function render()
    {
        return view('livewire.attendance.poll-edit')->layout('layouts.backend');
    }
}
