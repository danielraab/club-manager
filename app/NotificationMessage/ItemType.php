<?php

namespace App\NotificationMessage;

enum ItemType
{
    case SUCCESS;
    case WARNING;
    case ERROR;
    case INFORMATION;

    public static function getTypeForName(string $name): ?self
    {
        foreach(self::cases() as $case) {
            if($case->name === $name) return $case;
        }
        return null;
    }
}
