<?php

namespace App\Livewire\Events;

use App\Livewire\Forms\EventTypeForm;
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
        session()->put('message', __('The event type has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.events.event-type-create')->layout('layouts.backend');
    }
}
