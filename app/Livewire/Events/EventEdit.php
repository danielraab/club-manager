<?php

namespace App\Livewire\Events;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Notifications\UpcomingEvent;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use NotificationChannels\WebPush\PushSubscription;

class EventEdit extends Component
{
    public EventForm $eventForm;
    public array $cloneDateList = [];

    public function mount(Event $event): void
    {
        $this->eventForm->setEventModel($event);
    }

    public function updatingEventFormStart($updatedValue): void
    {
        $this->eventForm->updatingStart($updatedValue);
    }

    public function updatingEventFormEnd($updatedValue): void
    {
        $this->eventForm->updatingEnd($updatedValue);
    }

    public function deleteEvent()
    {
        $this->eventForm->delete();

        Log::info('Event deleted', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully deleted.'), ItemType::WARNING));

        return redirect(route('events.index'));
    }

    public function cloneEvent()
    {
        dd($this->cloneDateList);
    }

    public function saveEvent()
    {
        $this->eventForm->update();

        Log::info('Event updated', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully updated.'), ItemType::SUCCESS));
    }

    public function forceWebPush()
    {
        $this->eventForm->update();
        NotificationMessage::addSuccessNotificationMessage(__('The event has been successfully updated.'));

        \Illuminate\Support\Facades\Notification::send(
            PushSubscription::all(),
            new UpcomingEvent($this->eventForm->event)
        );
        Log::info('Event webPush forced', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addInfoNotificationMessage(__('A Web Push notification for this event has been forced.'));
    }

    public function render()
    {
        return view('livewire.events.event-edit')->layout('layouts.backend');
    }
}
