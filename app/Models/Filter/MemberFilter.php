<?php

namespace App\Models\Filter;

use App\Models\MemberGroup;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class MemberFilter
{
    public const PARAM_INCL_PAUSED = 'paused';

    public const PARAM_INCL_BEFORE = 'before';

    public const PARAM_INCL_AFTER = 'after';

    public const PARAM_INCL_MEMBER_GROUP_LIST = 'groupList';

    public bool $inclBeforeEntrance;

    public bool $inclAfterRetired;

    public bool $inclPaused;

    /** @var int[]|null */
    public ?array $memberGroupList;

    public function __construct(
        bool $inclBeforeEntrance = false,
        bool $inclAfterRetired = false,
        bool $inclPaused = false,
        MemberGroup $memberGroup = null)
    {
        $this->inclBeforeEntrance = $inclBeforeEntrance;
        $this->inclAfterRetired = $inclAfterRetired;
        $this->inclPaused = $inclPaused;
        $this->memberGroupList = null;
        if ($memberGroup) {
            $this->memberGroupList = Arr::map($memberGroup->getAllChildrenRecursive(), fn ($group) => $group->id);
        }
    }

    public function toParameterArray(): array
    {
        return [
            self::PARAM_INCL_PAUSED => $this->inclPaused,
            self::PARAM_INCL_BEFORE => $this->inclBeforeEntrance,
            self::PARAM_INCL_AFTER => $this->inclAfterRetired,
            self::PARAM_INCL_MEMBER_GROUP_LIST => $this->memberGroupList ?
                implode(',', $this->memberGroupList) : null,
        ];
    }

    public static function getMemberFilterFromRequest(): MemberFilter
    {
        $memberFilter = new MemberFilter(
            Request::get(self::PARAM_INCL_BEFORE),
            Request::get(self::PARAM_INCL_AFTER),
            Request::get(self::PARAM_INCL_PAUSED));

        $memberGroupParameter = Request::get(self::PARAM_INCL_MEMBER_GROUP_LIST);
        if ($memberGroupParameter) {
            $memberFilter->memberGroupList = explode(',', Request::get(self::PARAM_INCL_MEMBER_GROUP_LIST));
        }

        return $memberFilter;
    }
}
