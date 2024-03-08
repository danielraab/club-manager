<?php

namespace App\NotificationMessage;

use function Symfony\Component\String\s;

class NotificationMessage
{
    public function addNotificationMessage(\App\NotificationMessage\Item $messageItem): self
    {
        session()->push("notificationMessages", $messageItem);

        return $this;
    }

    public function popNotificationMessagesJson(): string
    {
        return json_encode(session()->pull("notificationMessages", []));
    }
}
