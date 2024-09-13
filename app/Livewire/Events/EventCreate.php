<?php

namespace App\Livewire\Events;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\EventForm;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EventCreate extends Component
{
    public EventForm $eventForm;

    public function mount(): void
    {
        $this->eventForm->enabled = true;
        $this->eventForm->whole_day = false;
        $initial = now()->addHour()->setMinute(0)->setSecond(0);
        $this->eventForm->start = $initial->formatDatetimeLocalInput();
        $this->eventForm->end = $initial->clone()->addHours(2)->formatDatetimeLocalInput();
    }

    public function updatingEventFormStart($updatedValue): void
    {
        $this->eventForm->updatingStart($updatedValue);
    }

    public function updatingEventFormEnd($updatedValue): void
    {
        $this->eventForm->updatingEnd($updatedValue);
    }

    /**
     * @throws ValidationException
     */
    public function saveEvent(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->eventForm->store();

        Log::info('Event created', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully created.'), ItemType::SUCCESS));

        return redirect(route('event.index'));
    }

    /**
     * @throws ValidationException
     */
    public function saveEventAndStay(): void
    {
        $this->eventForm->store();

        Log::info('Event created', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('New event successfully created. You can create the next one.'), ItemType::SUCCESS));
    }

    public function render()
    {
        return view('livewire.events.event-create')->layout('layouts.backend');
    }
}
