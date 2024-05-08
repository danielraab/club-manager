<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string id
 * @property string title
 * @property string|null description
 * @property bool allow_anonymous_vote
 * @property bool show_public_stats
 * @property \DateTime|null closing_at
 *
 * @see /database/migrations/2023_07_05_123614_attendance.php
 */
class AttendancePoll extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';

    public const ATTENDANCE_POLL_SHOW_PERMISSION = 'attendancePollShow';

    public const ATTENDANCE_POLL_EDIT_PERMISSION = 'attendancePollEdit';

    protected $fillable = [
        'title',
        'description',
        'allow_anonymous_vote',
        'show_public_stats',
        'closing_at',
        'member_group_id',
    ];

    protected $casts = [
        'allow_anonymous_vote' => 'boolean',
        'show_public_stats' => 'boolean',
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

    public function memberGroup(): BelongsTo
    {
        return $this->belongsTo(MemberGroup::class);
    }

    public function isPublicPollAvailable(): bool
    {
        return $this->allow_anonymous_vote === true &&
            $this->closing_at > now();
    }
}
