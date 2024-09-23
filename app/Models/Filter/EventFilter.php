<?php

namespace App\Models\Filter;

use App\Models\MemberGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class EventFilter
{
    public const PARAM_MEMBER_GROUP = 'memberGroup';

    public const PARAM_INCL_DISABLED = 'disabled';

    public const PARAM_START_DATE = 'start';

    public const PARAM_END_DATE = 'end';

    public bool $sortAsc;

    public bool $inclDisabled;

    /**
     * @var MemberGroup[]
     */
    public array $memberGroups;

    public ?Carbon $start;

    public ?Carbon $end;

    /**
     * @param  MemberGroup[]  $memberGroups
     */
    public function __construct(
        ?Carbon $start = null,
        ?Carbon $end = null,
        bool $inclDisabled = false,
        array $memberGroups = [],
        bool $sortAsc = true)
    {
        $this->inclDisabled = $inclDisabled;
        $this->memberGroups = $memberGroups;
        $this->sortAsc = $sortAsc;
        $this->start = $start;
        $this->end = $end;
    }

    public function toParameterArray(): array
    {
        return [
            self::PARAM_START_DATE => $this->start,
            self::PARAM_END_DATE => $this->end,
            self::PARAM_INCL_DISABLED => $this->inclDisabled,
            self::PARAM_MEMBER_GROUP => implode(',', array_map(
                fn (MemberGroup $mg) => $mg->id,
                $this->memberGroups
            )),
        ];
    }

    public static function getEventFilterFromRequest(): EventFilter
    {
        return new EventFilter(
            Request::get(self::PARAM_START_DATE),
            Request::get(self::PARAM_END_DATE),
            Request::get(self::PARAM_INCL_DISABLED),
            MemberGroup::query()->find(
                explode(',', Request::get(self::PARAM_MEMBER_GROUP))
            )->toArray());
    }
}
