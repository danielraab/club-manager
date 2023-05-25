<?php

namespace App\Http\Livewire\Events;

use Livewire\Component;

class EventTypeEdit extends Component
{
    use EventTypeTrait;

    public function mount($eventType)
    {
        $this->eventType = $eventType;
        $this->parent = $this->eventType->parent()->first()?->id;
    }


    public function saveEventType() {

        $this->saveEventTypeWithMessage(__("The event type has been successfully updated."));
    }

    public function deleteEventType()
    {
        $this->eventType->delete();
        session()->put("message", __("The event type has been successfully deleted."));
        $this->redirect(route("event.type.index"));
    }

    public function render()
    {
        return view('livewire.events.event-type-edit')->layout('layouts.backend');
    }
}
