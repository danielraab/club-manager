<?php

namespace App\Models;

use App\Models\Filter\MemberFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * @property int id
 * @property string firstname
 * @property string lastname
 * @property string|null title_pre
 * @property string|null title_post
 * @property bool paused
 * @property \DateTime|null birthday
 * @property string|null phone
 * @property string|null email
 * @property string|null street
 * @property string|null zip
 * @property string|null city
 * @property \DateTime entrance_date
 * @property \DateTime|null leaving_date
 * @property string|null external_id
 * @property \DateTime|null last_import_date
 *
 * @see /database/migrations/2023_06_12_204229_create_member_base_table.php
 * @see /database/migrations/2023_06_23_235409_member_table_add_external_data.php
 */
class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const MEMBER_EDIT_PERMISSION = 'memberEdit';

    public const MEMBER_SHOW_PERMISSION = 'memberShow';

    protected $fillable = [
        'firstname',
        'lastname',
        'title_pre',
        'title_post',
        'paused',
        'birthday',
        'phone',
        'email',
        'street',
        'zip',
        'city',
        'entrance_date',
        'leaving_date',
        'external_id',
        'last_import_date',
    ];

    protected $casts = [
        'paused' => 'bool',
        'birthday' => 'date',
        'entrance_date' => 'datetime',
        'leaving_date' => 'datetime',
        'last_import_date' => 'datetime',
    ];

    public function getFullName(): string
    {
        $fullName = '';
        if ($this->title_pre) {
            $fullName = $this->title_pre.' ';
        }
        $fullName .= $this->lastname.' '.$this->firstname;
        if ($this->title_post) {
            $fullName .= ' '.$this->title_post;
        }

        return $fullName;
    }

    /**
     * @deprecated use getAllFiltered method instead
     * @see Member::getAllFiltered
     */
    public static function allActive(bool $includePaused = false): Builder
    {
        $selection = self::query()->where('entrance_date', '<', now());
        if (! $includePaused) {
            $selection->where('paused', false);
        }
        $selection->where(function (Builder $query) {
            $query->whereNull('leaving_date')
                ->orWhere('leaving_date', '>', now());
        })->orderBy('lastname')->orderBy('firstname');

        return $selection;
    }

    public function matchFilter(MemberFilter $memberFilter): bool
    {
        return ($memberFilter->inclBeforeEntrance || $this->entrance_date === null || $this->entrance_date <= now()) &&
            ($memberFilter->inclAfterRetired || $this->leaving_date === null || $this->leaving_date >= now()) &&
            ($memberFilter->inclPaused || ! $this->paused) &&
            ($memberFilter->memberGroupList === null ||
                count($this->memberGroups()->pluck('id')->intersect(
                    Arr::pluck($memberFilter->memberGroupList, 'id'))) > 0);
    }

    public static function addFilterToBuilder(Builder $builder, MemberFilter $filter): Builder
    {

        if (! $filter->inclBeforeEntrance) {
            $builder->where('entrance_date', '<', now());
        }

        if (! $filter->inclAfterRetired) {
            $builder->where(function (Builder $query) {
                $query->whereNull('leaving_date')
                    ->orWhere('leaving_date', '>', now());
            });
        }

        if (! $filter->inclPaused) {
            $builder->where('paused', false);
        }

        if ($filter->memberGroupList) {
            $builder->whereHas('memberGroups', function ($query) use ($filter) {
                $query->whereIn('id', $filter->memberGroupList);
            });
        }

        return $builder;
    }

    public static function getAllFiltered(MemberFilter $filter = null): Builder
    {
        if ($filter === null) {
            $filter = new MemberFilter();
        }

        $selection = self::addFilterToBuilder(self::query(), $filter);

        $selection->orderBy('lastname')->orderBy('firstname');

        return $selection;
    }

    public function memberGroups(): BelongsToMany
    {
        return $this->belongsToMany(MemberGroup::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
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
