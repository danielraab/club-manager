<?php

namespace App\NotificationMessage;

class NotificationMessage
{
    /**
     * @var Item[]
     */
    private array $notificationMessages = [];

    public function addNotificationMessage(\App\NotificationMessage\Item $messageItem): self
    {
        $this->notificationMessages[] = $messageItem;

        return $this;
    }

    public function popNotificationMessagesJson(): string
    {
        $json = json_encode($this->notificationMessages);
        $this->notificationMessages = [];
        return $json;
    }
}
