<?php

namespace App\Models;

class MemberFilter
{
    public bool $inclBeforeEntrance;
    public bool $inclAfterRetired;
    public bool $inclPaused;


    /**
     * @param bool $inclBeforeEntrance
     * @param bool $inclAfterRetired
     * @param bool $inclPaused
     */
    public function __construct(bool $inclBeforeEntrance = false, bool $inclAfterRetired = false, bool $inclPaused = false)
    {
        $this->inclBeforeEntrance = $inclBeforeEntrance;
        $this->inclAfterRetired = $inclAfterRetired;
        $this->inclPaused = $inclPaused;
    }


}
