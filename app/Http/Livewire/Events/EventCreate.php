<?php

namespace App\Http\Livewire\Events;

use App\Http\Livewire\News\NewsTrait;
use App\Models\Event;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
        $this->start = now()->addWeek()->format("Y-m-d\TH:00");
        $this->end = now()->addWeek()->addHours(2)->format("Y-m-d\TH:00");
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
