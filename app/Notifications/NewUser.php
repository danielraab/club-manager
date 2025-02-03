<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly User $user, private readonly string $creator) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        if (empty($notifiable->email)) {
            Log::warning('Mail can not be sent to user because of missing email', [$notifiable, $this->user]);
        }

        $mailMessage = (new MailMessage)
            ->subject(__('New user created - :name', ['name' => $this->user->name]))
            ->greeting(__('Hello :name', ['name' => $notifiable->name]));

        $mailMessage->line(__('A new user was created via :creator.', ['creator' => $this->creator]));
        $mailMessage->line(__('New users name \':name\' and email: :email', ['name' => $this->user->name, 'email' => $this->user->email]));
        $mailMessage->line(__('You can now adjust the permissions.'));

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
