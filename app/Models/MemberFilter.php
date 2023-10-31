<?php

namespace App\Models;

class MemberFilter
{
    public bool $inclBeforeEntrance;
    public bool $inclAfterRetired;
    public bool $inclPaused;

    public ?MemberGroup $memberGroup;

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
        $this->memberGroup = $memberGroup;
    }


}
