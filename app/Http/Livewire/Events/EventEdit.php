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
        $this->previousUrl = url()->previous();
    }

    public function deleteEvent()
    {
        $this->event->delete();
        session()->put('message', __('The event has been successfully deleted.'));
        return redirect($this->previousUrl);
    }

    public function saveEventCopy()
    {
        $this->validate();
        $this->propToModel();
        $this->event->creator()->associate(Auth::user());
        $this->event->lastUpdater()->associate(Auth::user());

        $this->event = $this->event->replicate();
        $this->event->save();

        session()->put('message', __('The event has been successfully created.'));
        $this->redirect(route('event.edit', ["event" => $this->event->id]));
    }

    public function saveEvent()
    {
        $this->validate();
        $this->propToModel();
        $this->event->lastUpdater()->associate(Auth::user());
        $this->event->save();

        session()->put('message', __('The event has been successfully updated.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.events.event-edit')->layout('layouts.backend');
    }
}
