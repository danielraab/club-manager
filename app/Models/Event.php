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

    public static function getFutureEvents(bool $onlyEnabled = true, bool $inclLoggedInOnly = false)
    {

        $eventList = Event::query()->where('start', '>', now());
        if ($onlyEnabled) {
            $eventList = $eventList->where('enabled', true);
        }
        if (! $inclLoggedInOnly) {
            $eventList = $eventList->where('logged_in_only', false);
        }

        return $eventList->orderBy('start');
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

    public function getAttendanceStatistics(): array
    {
        $cntIn = 0;
        $cntUnsure = 0;
        $cntOut = 0;
        $cntAttended = 0;
        $cntMembers = Member::allActive()->count();

        $attendances = $this->attendances()->get();

        $memberGroupCntList = [];

        foreach ($attendances as $attendance) {
            /** @var Attendance $attendance */
            if ($attendance->poll_status === 'in') {
                $cntIn++;
            }
            if ($attendance->poll_status === 'unsure') {
                $cntUnsure++;
            }
            if ($attendance->poll_status === 'out') {
                $cntOut++;
            }
            if ($attendance->attended === true) {
                $cntAttended++;
            }

            foreach ($attendance->member()->first()->memberGroups()->get() as $memberGroup) {
                $groupElem = $memberGroupCntList[$memberGroup->id] ?? [
                    'in' => 0,
                    'unsure' => 0,
                    'out' => 0,
                ];
                if ($attendance->poll_status === 'in') {
                    $groupElem['in'] = $groupElem['in'] + 1;
                }
                if ($attendance->poll_status === 'unsure') {
                    $groupElem['unsure'] = $groupElem['unsure'] + 1;
                }
                if ($attendance->poll_status === 'out') {
                    $groupElem['out'] = $groupElem['out'] + 1;
                }
                $memberGroupCntList[$memberGroup->id] = $groupElem;
            }
        }

        return [
            'in' => $cntIn,
            'unsure' => $cntUnsure,
            'out' => $cntOut,
            'attended' => $cntAttended,
            'memberGroupStatistics' => $memberGroupCntList,
        ];
    }
}
