<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const EVENT_EDIT_PERMISSION = 'eventEdit';

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'enabled' => 'boolean',
        'whole_day' => 'boolean',
    ];

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }


    public function attendancePolls(): BelongsToMany
    {
        return $this->belongsToMany(AttendancePoll::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getLocationHistory(): array
    {
        return self::query()->select('location')->distinct()
            ->orderBy('location')->pluck('location')->toArray();
    }

    public static function getDressCodeHistory(): array
    {
        return self::query()->select('dress_code')->distinct()
            ->orderBy('dress_code')->pluck('dress_code')->toArray();
    }
}
