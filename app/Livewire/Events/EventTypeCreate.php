<?php

namespace App\Livewire\Events;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\EventTypeForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EventTypeCreate extends Component
{
    public EventTypeForm $eventTypeForm;

    public string $previousUrl;

    public function mount()
    {
        $this->previousUrl = url()->previous();
    }

    /**
     * @throws ValidationException
     */
    public function saveEventType()
    {
        $this->eventTypeForm->store();

        Log::info("Event type created", [auth()->user(), $this->eventTypeForm->eventType]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event type has been successfully created.'), ItemType::SUCCESS));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.events.event-type-create')->layout('layouts.backend');
    }
}
