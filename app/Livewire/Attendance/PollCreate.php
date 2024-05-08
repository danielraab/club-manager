<?php

namespace App\Livewire\Attendance;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\PollForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PollCreate extends Component
{
    public PollForm $pollForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->pollForm->allow_anonymous_vote = true;
        $this->pollForm->closing_at =
            now()->addWeek()->setMinute(0)->setSecond(0)->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    public function addEventsToSelection($additionalEventIdList): void
    {
        $this->pollForm->addEventsToSelection($additionalEventIdList);
    }

    public function removeEventFromSelection($eventId): void
    {
        $this->pollForm->removeEventFromSelection($eventId);
    }

    public function savePoll()
    {
        $this->pollForm->store();

        Log::info('Poll created', [auth()->user(), $this->pollForm->poll]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The attendance poll has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.attendance.poll-create')->layout('layouts.backend');
    }
}
