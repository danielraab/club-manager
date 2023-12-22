<?php

namespace App\Livewire\Events;

use App\Livewire\Forms\EventForm;
use Livewire\Component;

class EventCreate extends Component
{
    public EventForm $eventForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->eventForm->enabled = true;
        $this->eventForm->logged_in_only = false;
        $this->eventForm->whole_day = false;
        $initial = now()->addHour()->setMinute(0)->setSecond(0);
        $this->eventForm->start = $initial->formatDatetimeLocalInput();
        $this->eventForm->end = $initial->clone()->addHours(2)->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    public function saveEvent()
    {
        $this->eventForm->store();

        session()->put('message', __('The event has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function saveEventAndStay(): void
    {
        $this->eventForm->store();

        session()->flash('savedAndStayMessage', __('New event created.'));
    }

    public function render()
    {
        return view('livewire.events.event-create')->layout('layouts.backend');
    }
}
