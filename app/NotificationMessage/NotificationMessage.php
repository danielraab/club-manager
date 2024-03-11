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

    public function addSuccessNotificationMessage(string $message): self
    {
        return $this->addNotificationMessage(new Item($message, ItemType::SUCCESS));
    }
    public function addWarningNotificationMessage(string $message): self
    {
        return $this->addNotificationMessage(new Item($message, ItemType::WARNING));
    }
    public function addErrorNotificationMessage(string $message): self
    {
        return $this->addNotificationMessage(new Item($message, ItemType::ERROR));
    }
    public function addInfoNotificationMessage(string $message): self
    {
        return $this->addNotificationMessage(new Item($message, ItemType::INFORMATION));
    }
}
