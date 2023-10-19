<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int id
 * @property string title
 * @property ?string description
 * @property int sort_order
 * @property ?int parent_id
 * @property ?EventType parent
 * @see /database/migrations/2023_05_20_223845_create_events_table.php
 */
class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'parent_id',
    ];

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
        foreach (EventType::getTopLevelQuery()->get() as $eventType) {

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

    public static function getTopLevelQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return self::query()->whereNull('parent_id')->orderBy('sort_order')->orderBy('title');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
