<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventType extends Model
{
    use HasFactory;


    public function parent():BelongsTo {
        return $this->belongsTo(EventType::class);
    }

    public function children():HasMany {
        return $this->hasMany(EventType::class, "parent_id");
    }

    public static function getOrderedAndPrefixedList() {
        $orderedArr = [];
        foreach(EventType::query()->whereNull("parent_id")->get() as $eventType) {
            $orderedArr[$eventType->id]["title"] = $eventType->title;

            foreach($eventType->children()->get() as $firstSub)
            {
                $orderedArr[$eventType->id]["children"][$firstSub->id]["title"] = $firstSub->title;
                foreach($firstSub->children()->get() as $secondSub)
                {
                    $orderedArr[$eventType->id]["children"][$firstSub->id]["children"][$secondSub->id]["title"] = $secondSub->title;
                }
            }
        }
        return $orderedArr;
    }
}
