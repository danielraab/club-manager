<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * @method static popNotificationMessagesJson(): string
 * @method static addNotificationMessage(\App\NotificationMessage\Item $messageItem): self
 * @method static addSuccessNotificationMessage(string $message): self
 * @method static addWarningNotificationMessage(string $message): self
 * @method static addErrorNotificationMessage(string $message): self
 * @method static addInfoNotificationMessage(string $message): self
 *
 * @see \App\NotificationMessage\NotificationMessage
 */
class NotificationMessage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "notificationMessage";
    }
}
