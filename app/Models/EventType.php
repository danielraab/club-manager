<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(EventType::class, 'parent_id');
    }

    public static function getLeveledList(): array
    {
        $orderedArr = [];
        foreach (EventType::query()->whereNull('parent_id')->get() as $eventType) {

            self::addEventTypeToArray($eventType, $orderedArr);
        }

        return $orderedArr;
    }

    private static function addEventTypeToArray(EventType $eventType, array &$eventTypeArr, int $level = 0): void
    {
        $eventTypeArr[] = [
            'id' => $eventType->id,
            'label' => $eventType->title,
            'level' => $level,
        ];

        foreach ($eventType->children()->get() as $child) {
            self::addEventTypeToArray($child, $eventTypeArr, $level + 1);
        }
    }
}
