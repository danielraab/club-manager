<?php

namespace App\Models;

class MemberFilter
{
    public bool $inclBeforeEntrance;
    public bool $inclAfterRetired;
    public bool $inclPaused;

    /** @var MemberGroup[]|null  */
    public ?array $memberGroupList;

    /**
     * @param bool $inclBeforeEntrance
     * @param bool $inclAfterRetired
     * @param bool $inclPaused
     * @param MemberGroup|null $memberGroup
     */
    public function __construct(
        bool $inclBeforeEntrance = false,
        bool $inclAfterRetired = false,
        bool $inclPaused = false,
        ?MemberGroup $memberGroup = null)
    {
        $this->inclBeforeEntrance = $inclBeforeEntrance;
        $this->inclAfterRetired = $inclAfterRetired;
        $this->inclPaused = $inclPaused;
        $this->memberGroupList = null;
        if($memberGroup) {
            $this->memberGroupList = $memberGroup->getAllChildrenRecursive();
        }
    }


}
