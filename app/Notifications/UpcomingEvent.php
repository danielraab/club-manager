<?php

namespace App\Notifications;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpcomingEvent extends Notification
{
    use Queueable;

    private Event $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $body = __("Please be aware of the event ':name' on :date", [
            "name" => $this->event->title,
            "date" => $this->event->start->formatDateTimeWithSec()
        ]);

        $diff = $this->event->start->diff(now());
        if($diff->invert === 1 && $diff->days === 1) {
            $body = __("Be aware of tomorrows event ':name' on :date", [
                "name" => $this->event->title,
                "date" => $this->event->start->setTimezone(config('app.displayed_timezone'))->isoFormat('HH:mm')
            ]);
        }

        return (new WebPushMessage())
            ->title(__(":app - event", ["app" => config("app.name")]))
            ->icon(url('/').'/logo.svg')
            ->body($body)
            ->action(__('View Events'), 'events');
    }
}
