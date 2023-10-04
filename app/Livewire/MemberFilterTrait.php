<?php

namespace App\Livewire;

use App\Models\MemberFilter;

trait MemberFilterTrait
{
    public bool $filterShowBeforeEntrance = false;
    public bool $filterShowAfterRetired = false;
    public bool $filterShowPaused = false;

    public function getMemberFilter(): MemberFilter
    {
        return new MemberFilter($this->filterShowBeforeEntrance, $this->filterShowAfterRetired, $this->filterShowPaused);
    }
}
