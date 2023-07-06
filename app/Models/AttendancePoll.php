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


    public const ATTENDANCE_POLL_SHOW_PERMISSION = 'attendancePollShow';
    public const ATTENDANCE_POLL_EDIT_PERMISSION = 'attendancePollEdit';


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
}
