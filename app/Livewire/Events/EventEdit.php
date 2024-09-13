<?php

namespace App\Livewire\Events;

use App\Facade\NotificationMessage;
use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use App\Notifications\UpcomingEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use NotificationChannels\WebPush\PushSubscription;

class EventEdit extends Component
{
    public EventForm $eventForm;

    public array $copyDateList = [];

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

    public function deleteEvent(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $this->eventForm->delete();

        Log::info('Event deleted', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully deleted.'), ItemType::WARNING));

        return redirect(route('events.index'));
    }

    /**
     * @throws ValidationException
     */
    public function copyEvent(): void
    {

        $eventData = array_map(function ($date) {
            return new Carbon($date);
        }, $this->copyDateList);

        if (count($eventData) === 0) {
            NotificationMessage::addInfoNotificationMessage(__('No dates selected to copy event.'));

            return;
        }

        $this->eventForm->copy($eventData);
        $this->copyDateList = [];

        Log::info('Event copied', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addSuccessNotificationMessage(
            __('The event has been successfully copied. :cnt new events created.', ['cnt' => count($eventData)])
        );

        $this->dispatch('close-modal', 'copy-event-modal');
    }

    /**
     * @throws ValidationException
     */
    public function saveEvent(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->eventForm->update();

        Log::info('Event updated', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully updated.'), ItemType::SUCCESS));

        return redirect(route('event.index'));
    }

    /**
     * @throws ValidationException
     */
    public function saveAndStay(): void
    {
        $this->eventForm->update();

        Log::info('Event updated', [auth()->user(), $this->eventForm->event]);
        NotificationMessage::addNotificationMessage(
            new Item(__('The event has been successfully updated.'), ItemType::SUCCESS));
    }

    /**
     * @throws ValidationException
     */
    public function forceWebPush(): void
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
