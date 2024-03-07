<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * @method static popNotificationMessagesJson(): string
 * @method static addNotificationMessage(\App\NotificationMessage\Item $messageItem): self
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
