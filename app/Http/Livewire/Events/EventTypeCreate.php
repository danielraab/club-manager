<?php

namespace App\Http\Livewire\Events;

use App\Models\EventType;
use Livewire\Component;

class EventTypeCreate extends Component
{
    use EventTypeTrait;

    public function mount()
    {
        $this->eventType = new EventType();
    }


    public function saveEventType() {

        $this->saveEventTypeWithMessage(__("The event type has been successfully created."));
    }

    public function render()
    {
        return view('livewire.events.event-type-create')->layout('layouts.backend');
    }
}
