<?php

namespace App\Livewire;

use App\Models\Filter\MemberFilter;
use App\Models\MemberGroup;

trait MemberFilterTrait
{
    public string $filterMemberGroup = '';

    public bool $filterShowBeforeEntrance = false;

    public bool $filterShowAfterRetired = false;

    public bool $filterShowPaused = false;

    public function getMemberFilter(): MemberFilter
    {
        $selectedMemberGroup = MemberGroup::query()->find(intval($this->filterMemberGroup));

        return new MemberFilter(
            $this->filterShowBeforeEntrance,
            $this->filterShowAfterRetired,
            $this->filterShowPaused,
            $selectedMemberGroup);
    }
}
