<?php

namespace App\Livewire;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\Filter\MemberFilter;
use App\Models\MemberGroup;

trait MemberFilterTrait
{
    public string $filterMemberGroup = '';

    public bool $filterShowBeforeEntrance = false;

    public bool $filterShowAfterRetired = false;

    public bool $filterShowPaused = false;

    public bool $useMemberGroupFilter = true;

    public function initFilter(): void
    {
        $this->filterShowPaused = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_PAUSED, auth()->user(), false);
        $this->filterShowAfterRetired = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_AFTER_RETIRED, auth()->user(), false);
        $this->filterShowBeforeEntrance = Configuration::getBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_BEFORE_ENTRANCE, auth()->user(), false);
        if ($this->useMemberGroupFilter) {
            $this->filterMemberGroup = (string) Configuration::getInt(
                ConfigurationKey::MEMBER_FILTER_GROUP_ID, auth()->user()) ?: '';
        }
    }

    public function updatedFilterShowPaused(): void
    {
        Configuration::storeBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_PAUSED,
            $this->filterShowPaused,
            auth()->user()
        );
    }

    public function updatedFilterShowAfterRetired(): void
    {
        Configuration::storeBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_AFTER_RETIRED,
            $this->filterShowAfterRetired,
            auth()->user()
        );
    }

    public function updatedFilterShowBeforeEntrance(): void
    {
        Configuration::storeBool(
            ConfigurationKey::MEMBER_FILTER_SHOW_BEFORE_ENTRANCE,
            $this->filterShowBeforeEntrance,
            auth()->user()
        );
    }

    public function updatedFilterMemberGroup(): void
    {
        $groupId = intval($this->filterMemberGroup);
        Configuration::storeInt(
            ConfigurationKey::MEMBER_FILTER_GROUP_ID,
            $groupId,
            auth()->user()
        );
    }

    public function getMemberFilter(): MemberFilter
    {
        $selectedMemberGroup = null;
        if ($this->useMemberGroupFilter) {
            $selectedMemberGroup = MemberGroup::query()->find(intval($this->filterMemberGroup));
        }

        return new MemberFilter(
            $this->filterShowBeforeEntrance,
            $this->filterShowAfterRetired,
            $this->filterShowPaused,
            $selectedMemberGroup);
    }
}
