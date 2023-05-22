<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Livewire\Component;
use Livewire\WithPagination;
use function Symfony\Component\Translation\t;

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
        if(Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $event->enabled = !$event->enabled;
            $event->lastUpdater()->associate(Auth::user());
            $event->save();
        } else {
            abort(403);
        }
    }

    public function render()
    {
        return view('events.event-overview', [
            'eventList' => $this->getEventList()
        ])->layout("layouts.backend");
    }

    private function getEventList()
    {
        $eventList = Event::orderBy('start', 'desc');
        if (Auth::guest()) {
            $eventList = $eventList->where("logged_in_only", false);
            $eventList = $eventList->where("enabled", true);
        } elseif (!Auth::user()->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $eventList = $eventList->where("enabled", true);
        }

        if ($this->search && strlen($this->search) >= 3) {
            $eventList = $eventList->where("title", "like", "%$this->search%");
        }

        return $eventList->paginate(10);
    }
}
