<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const AVAILABLE_POLL_STATUS_LIST = ['in', 'out', 'unsure'];

    public const ATTENDANCE_SHOW_PERMISSION = 'attendanceShow';

    public const ATTENDANCE_EDIT_PERMISSION = 'attendanceEdit';

    protected $casts = [
        'attended' => 'boolean',
    ];

    protected $fillable = [
        'event_id', 'member_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdater(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
