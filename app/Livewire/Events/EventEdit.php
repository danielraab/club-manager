<?php

namespace App\Livewire\Events;

use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\Notifications\UpcomingEvent;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use NotificationChannels\WebPush\PushSubscription;

class EventEdit extends Component
{
    public EventForm $eventForm;

    public string $previousUrl;

    public function mount(Event $event): void
    {
        $this->eventForm->setEventModel($event);
        $this->previousUrl = url()->previous();
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

        Log::info("Event deleted", [auth()->user(), $this->eventForm->event]);
        session()->put('message', __('The event has been successfully deleted.'));

        return redirect($this->previousUrl);
    }

    public function saveEventCopy()
    {
        $this->eventForm->store();

        Log::info("Event copied", [auth()->user(), $this->eventForm->event]);
        session()->put('message', __('The event has been successfully created.'));

        return redirect(route('event.edit', ['event' => $this->eventForm->event->id]));
    }

    public function saveEvent()
    {
        $this->eventForm->update();

        Log::info("Event updated", [auth()->user(), $this->eventForm->event]);
        session()->put('message', __('The event has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function forceWebPush()
    {
        $this->eventForm->update();

        \Illuminate\Support\Facades\Notification::send(
            PushSubscription::all(),
            new UpcomingEvent($this->eventForm->event)
        );
        Log::info("Event webPush forced", [auth()->user(), $this->eventForm->event]);
    }

    public function render()
    {
        return view('livewire.events.event-edit')->layout('layouts.backend');
    }
}
