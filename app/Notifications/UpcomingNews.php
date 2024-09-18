<?php

namespace App\Notifications;

use App\Models\ApplicationLogo;
use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class UpcomingNews extends Notification
{
    use Queueable;

    private News $news;

    /**
     * Create a new notification instance.
     */
    public function __construct(News $news)
    {
        $this->news = $news;
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
        $body = __('Please be aware of the news :name', [
            'name' => $this->news->title,
        ]);

        return (new WebPushMessage)
            ->title(__(':app - news', ['app' => config('app.name')]))
            ->icon(ApplicationLogo::getUrl())
            ->body($body)
            ->action(__('View News'), 'news-detail')
            ->data(['id' => $this->news->id]);
    }
}
