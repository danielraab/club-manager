<?php

namespace App\Livewire\Events;

use App\Livewire\Forms\EventTypeForm;
use App\Models\EventType;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EventTypeEdit extends Component
{
    public EventTypeForm $eventTypeForm;

    public string $previousUrl;

    public function mount(EventType $eventType)
    {
        $this->eventTypeForm->setEventType($eventType);
        $this->previousUrl = url()->previous();
    }

    /**
     * @throws ValidationException
     */
    public function saveEventType()
    {
        $this->eventTypeForm->update();

        Log::info("Event type updated", [auth()->user(), $this->eventTypeForm->eventType]);
        session()->put('message', __('The event type has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function deleteEventType()
    {
        $this->eventTypeForm->delete();

        Log::info("Event type deleted", [auth()->user(), $this->eventTypeForm->eventType]);
        session()->put('message', __('The event type has been successfully deleted.'));

        return redirect(route('event.type.index'));
    }

    public function render()
    {
        return view('livewire.events.event-type-edit')->layout('layouts.backend');
    }
}
