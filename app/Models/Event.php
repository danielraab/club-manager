<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    public const EVENT_EDIT_PERMISSION = 'eventEdit';

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'enabled' => 'boolean',
        'whole_day' => 'boolean'
    ];

    public function eventType():BelongsTo {
        return $this->belongsTo(EventType::class);
    }

    public function creator():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater():BelongsTo {
        return $this->belongsTo(User::class);
    }
}
