<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EventOverview extends Component
{
    use WithPagination;

    public ?string $search = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleEnabledState(Event $event)
    {
        if (Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $event->enabled = ! $event->enabled;
            $event->lastUpdater()->associate(Auth::user());
            $event->save();
        } else {
            abort(403);
        }
    }

    public function disableLastYearEvents()
    {
        $cnt = Event::where("end", "<", now()->setMonth(0)->setDay(0)->setTime(0,0,0))
            ->update(["enabled"=> false]);
        session()->flash("eventDisableMessage", __("Done. :cnt Event(s) affected.",["cnt"=>$cnt]));
    }

    public function render()
    {
        return view('livewire.events.event-overview', [
            'eventList' => $this->getEventList(),
        ])->layout('layouts.backend');
    }

    private function getEventList()
    {
        $eventList = Event::orderBy('start', 'desc');
        if (Auth::guest()) {
            $eventList = $eventList->where('logged_in_only', false);
            $eventList = $eventList->where('enabled', true);
        } elseif (! Auth::user()->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $eventList = $eventList->where('enabled', true);
        }

        if ($this->search && strlen($this->search) >= 3) {
            $eventList = $eventList->where('title', 'like', "%$this->search%");
        }

        return $eventList->paginate(20)->onEachSide(1);
    }
}
