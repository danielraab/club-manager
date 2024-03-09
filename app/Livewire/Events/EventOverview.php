<?php

namespace App\Livewire\Events;

use App\Facade\NotificationMessage;
use App\Livewire\EventFilterTrait;
use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\Event;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EventOverview extends Component
{
    use EventFilterTrait, WithPagination;

    public ?string $search = null;

    public function mount(): void
    {
        $this->end = \App\Models\Configuration::getString(
            \App\Models\ConfigurationKey::EVENT_FILTER_DEFAULT_END_DATE) ?: "";

        $useTodayAsStart = (bool)Configuration::getBool(ConfigurationKey::EVENT_FILTER_DEFAULT_START_TODAY);
        if($useTodayAsStart) {
            $this->start = now()->setTime(0,0,0)->formatDateInput();
            return;
        }
        $this->start = \App\Models\Configuration::getString(
            \App\Models\ConfigurationKey::EVENT_FILTER_DEFAULT_START_DATE) ?: "";
    }

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
        if (Auth::user()?->hasPermission(Event::EVENT_EDIT_PERMISSION)) {
            $cnt = Event::query()
                ->where('end', '<', now()->setMonth(1)->setDay(1)->setTime(0, 0, 0))
                ->where("enabled", true)
                ->update(['enabled' => false]);

            NotificationMessage::addNotificationMessage(
                new Item(__('Done. :cnt Event(s) affected.', ['cnt' => $cnt])));
        } else {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.events.event-overview', [
            'eventList' => $this->getEventList(),
        ])->layout('layouts.backend');
    }

    private function getEventList()
    {
        $eventFilter = $this->getEventFilter();
        $eventList = Event::getAllFiltered($eventFilter);

        if ($this->search && strlen($this->search) >= 3) {
            $eventList = $eventList->where('title', 'like', "%$this->search%");
        }

        return $eventList->paginate(20)->onEachSide(1);
    }
}
