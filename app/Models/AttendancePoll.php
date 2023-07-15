<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttendancePoll extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = "string";

    public const ATTENDANCE_POLL_SHOW_PERMISSION = 'attendancePollShow';
    public const ATTENDANCE_POLL_EDIT_PERMISSION = 'attendancePollEdit';

    protected $casts = [
        'allow_anonymous_vote' => 'boolean',
        'closing_at' => 'datetime',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublicPollAvailable(): bool
    {
        return $this->allow_anonymous_vote === true &&
            $this->closing_at > now();
    }
}
