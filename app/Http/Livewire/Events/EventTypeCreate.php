<?php

namespace App\Http\Livewire\Events;

use App\Models\EventType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventTypeCreate extends Component
{
    use EventTypeTrait;

    public function mount()
    {
        $this->eventType = new EventType();
    }


    public function saveEventType() {
        $this->validate();
        $this->propToModel();
        $this->eventType->save();

        session()->put("message", __("The event type has been successfully created."));
        $this->redirect(route("event.type.index"));
    }

    public function render()
    {
        return view('livewire.events.event-type-create')->layout('layouts.backend');
    }
}
