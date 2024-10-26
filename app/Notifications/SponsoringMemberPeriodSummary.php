<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\Sponsoring\Period;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class SponsoringMemberPeriodSummary extends Notification
{
    use Queueable;

    private Period $period;

    private iterable $contracts;

    private User $user;

    private bool $sendBlindCopyToUser;

    private string $additionalText;

    /**
     * Create a new notification instance.
     */
    public function __construct(Period $period, iterable $contracts, User $user, string $additionalText, bool $sendBlindCopyToUser)
    {
        $this->period = $period;
        $this->contracts = $contracts;
        $this->user = $user;
        $this->sendBlindCopyToUser = $sendBlindCopyToUser;
        $this->additionalText = trim(strip_tags($additionalText));
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
            ->subject(__('Personal sponsoring Summary - :period', ['period' => $this->period->title]))
            ->greeting(__('Hello :name', ['name' => $notifiable->getFullName()]));

        if ($this->additionalText) {
            $mailMessage->line($this->additionalText);
        }

        $mailMessage->line(__('Thanks for asking the following Backers about a sponsoring:'));

        $mailMessage->replyTo($this->user->email);
        if ($this->sendBlindCopyToUser) {
            $mailMessage->bcc($this->user->email);
        }

        foreach ($this->contracts as $contract) {
            $mailMessage->line('* '.$contract->backer->name);
        }

        if (count($this->period->uploadedFiles)) {
            $mailMessage->line(__('Here you can find useful files:'));
            $listItems = [];
            foreach ($this->period->uploadedFiles as $uploadedFile) {
                $listItems[] = "<li><a href='{$uploadedFile->getUrl()}'>{$uploadedFile->name}</a></li>";
            }
            $mailMessage->line(new HtmlString('<ul>'.implode('', $listItems).'</ul>'));
        }

        $mailMessage->salutation(__("Best regards,\n:name", ['name' => $this->user->getNameWithMail()]));

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
