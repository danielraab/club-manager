<?php

namespace App\Models;

use App\Models\Filter\EventFilter;
use App\Models\Filter\MemberFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string|null description
 * @property string|null location
 * @property string|null dress_code
 * @property Carbon start
 * @property Carbon end
 * @property bool whole_day
 * @property bool enabled
 * @property bool logged_in_only
 * @property string|null link
 * @property ?int event_type_id
 * @property ?EventType eventType
 *
 * @see /database/migrations/2023_05_20_223845_create_events_table.php
 */
class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const EVENT_EDIT_PERMISSION = 'eventEdit';

    protected $fillable = [
        'title',
        'description',
        'location',
        'dress_code',
        'start',
        'end',
        'whole_day',
        'enabled',
        'logged_in_only',
        'link',
        'event_type_id',
    ];

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

    public function getFormattedStart(): string
    {
        $start = $this->start->setTimezone(config('app.displayed_timezone'));

        return $this->formatDateTime($start);
    }

    public function getFormattedEnd(): string
    {
        $end = $this->end->setTimezone(config('app.displayed_timezone'));

        return $this->formatDateTime($end);
    }

    private function formatDateTime($datetime): string
    {
        if ($this->whole_day) {
            return $datetime->isoFormat('ddd D. MMM YYYY');
        }

        return $datetime->isoFormat('ddd D. MMM YYYY - HH:mm');
    }

    public static function getFutureEvents(bool $onlyEnabled = true, bool $inclLoggedInOnly = false)
    {

        $eventList = Event::query()->where('end', '>', now());
        if ($onlyEnabled) {
            $eventList = $eventList->where('enabled', true);
        }
        if (! $inclLoggedInOnly) {
            $eventList = $eventList->where('logged_in_only', false);
        }

        return $eventList->orderBy('start');
    }

    public static function addFilterToBuilder(Builder $builder, EventFilter $filter): Builder
    {
        if ($filter->start) {
            //includes events which end after the specified start date
            $builder->where('end', '>=', $filter->start);
        }

        if ($filter->end) {
            //includes events which start before the specified end date
            $builder->where('start', '<=', $filter->end);
        }

        if (! $filter->inclDisabled) {
            $builder->where('enabled', true);
        }

        if (! $filter->inclLoggedInOnly) {
            $builder->where('logged_in_only', false);
        }

        $builder->orderBy('start', $filter->sortAsc ? 'asc' : 'desc');

        return $builder;
    }

    public static function getAllFiltered(EventFilter $filter = null): Builder
    {
        if ($filter === null) {
            $filter = new EventFilter();
        }

        return self::addFilterToBuilder(self::query(), $filter);
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
