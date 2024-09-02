<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\Sponsoring\Period;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SponsoringMemberPeriodSummary extends Notification
{
    use Queueable;

    private Period $period;

    private Collection $contracts;

    /**
     * Create a new notification instance.
     */
    public function __construct(Period $period, Collection $contracts)
    {
        $this->period = $period;
        $this->contracts = $contracts;
    }

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
    public function toMail(Member $notifiable): MailMessage
    {
        if (empty($notifiable->email)) {
            Log::warning('Mail can not be sent to member because of missing email', [$notifiable, $this->period]);
        }

        $mailMessage = (new MailMessage)
            ->subject(__("Sponsoring Member Summary - :period", [ "period" => $this->period->title]))
            ->greeting(__('Hello :name', ["name" => $notifiable->getFullName()]))
            ->line(__('Thanks for asking the following Backers about a sponsoring:'));

        foreach ($this->contracts as $contract) {
            $mailMessage->line('* '.$contract->backer->name);
        }

        if (count($this->period->uploadedFiles)) {
            $mailMessage->line(__('Here you can find useful files:'));
            foreach ($this->period->uploadedFiles as $uploadedFile) {
                $mailMessage->action($uploadedFile->name, $uploadedFile->getUrl());
            }
        }

        $user = auth()->user();
        if ($user instanceof User) {
            $mailMessage->salutation(__("Best regards,\n:name",["name" => $user->getNameWithMail()]));
        }

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
