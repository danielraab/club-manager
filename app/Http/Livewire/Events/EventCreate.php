<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventCreate extends Component
{
    use EventTrait;

    public function mount()
    {
        $this->event = new Event();
        $this->event->enabled = true;
        $this->event->logged_in_only = false;
        $this->event->whole_day = false;
        $initial = now()->setMinute(0)->setSecond(0);
        $this->start = $initial->formatDatetimeLocalInput();
        $this->end = $initial->clone()->addHours(2)->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    public function saveEvent()
    {
        $this->validate();
        $this->propToModel();
        $this->event->creator()->associate(Auth::user());
        $this->event->lastUpdater()->associate(Auth::user());
        $this->event->save();

        session()->put('message', __('The event has been successfully created.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.events.event-create')->layout('layouts.backend');
    }
}
