<?php

namespace App\Notifications;

use App\Models\Event;
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
        $body = __("Do not forget the event ':name' on :date", [
            "name" => $this->event->title,
            "date" => $this->event->getFormattedStart()
        ]);

        return (new WebPushMessage())
            ->title(__(":app - event", ["app" => config("app.name")]))
            ->icon(url('/').'/logo.svg')
            ->body($body)
            ->action(__('View Events'), 'event-detail')
            ->data(["id"=>$this->event->id]);
    }
}
