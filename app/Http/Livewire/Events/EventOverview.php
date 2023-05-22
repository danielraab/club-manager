<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
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

    public function render()
    {
        $eventList = Event::orderBy('start', 'desc');
        if(Auth::guest()) {
            $eventList = $eventList->where("logged_in_only", false);
        } elseif(!Auth::user()->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $eventList = $eventList->where("enabled", true);
        }

        if($this->search && strlen($this->search) >= 3) {
            $eventList = $eventList->where("title", "like", "%$this->search%");
        }

        $eventList = $eventList->paginate(10);

        return view('events.event-overview', [
            'eventList' => $eventList
        ])->layout("layouts.backend");
    }
}
