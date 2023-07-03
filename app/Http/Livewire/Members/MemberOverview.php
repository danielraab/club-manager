<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use App\Models\MemberGroup;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MemberOverview extends Component
{
    public bool $onlyActive = false;
    public string $filterMemberGroup = "";

    public function getMembersProperty() {

        /** @var Builder $memberList */
        $memberList = Member::orderBy("lastname")->orderBy("firstname");

        if ($this->onlyActive) {
            $memberList = Member::allActive();
        }

        if($this->filterMemberGroup) {
            /** @var MemberGroup $selectedGroup */
            $selectedGroup = MemberGroup::query()->find(intval($this->filterMemberGroup));
            $groupChildList = $selectedGroup?->getAllChildrenRecursive() ?: [];
            $memberList->whereHas('memberGroups', function($query) use ($groupChildList) {
                $query->whereIn('id', array_map(fn($group) => $group->id, $groupChildList));
            });
        }

        return $memberList;
    }

    public function render()
    {
        return view('livewire.members.member-overview')->layout('layouts.backend');
    }
}
