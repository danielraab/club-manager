<?php

namespace App\Http\Livewire\Events;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventEdit extends Component
{
    use EventTrait;

    public function mount($event)
    {
        $this->event = $event;
        $this->start = $this->event->start->formatDatetimeLocalInput();
        $this->end = $this->event->end->formatDatetimeLocalInput();
        $this->type = $this->event->eventType?->id;
    }

    public function deleteEvent()
    {
        $this->event->delete();
        session()->put('message', __('The event has been successfully deleted.'));
        $this->redirect(route('event.index'));
    }

    public function saveEvent()
    {
        $this->validate();
        $this->propToModel();
        $this->event->lastUpdater()->associate(Auth::user());
        $this->event->save();

        session()->put('message', __('The event has been successfully updated.'));
        $this->redirect(route('event.index'));
    }

    public function render()
    {
        return view('livewire.events.event-edit')->layout('layouts.backend');
    }
}
