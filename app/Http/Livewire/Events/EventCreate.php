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
        $initial = now()->addWeek()->setMinute(0)->setSecond(0);
        $this->start = $initial->format($this->datetimeLocalFormat);
        $this->end = $initial->clone()->addHours(2)->format($this->datetimeLocalFormat);
    }


    public function saveEvent() {
        $this->validate();
        $this->propToModel();
        $this->event->creator()->associate(Auth::user());
        $this->event->lastUpdater()->associate(Auth::user());
        $this->event->save();

        session()->put("message", __("The event has been successfully created."));
        $this->redirect(route("events.index"));
    }

    public function render()
    {
        return view('livewire.events.event-create')->layout('layouts.backend');
    }
}
