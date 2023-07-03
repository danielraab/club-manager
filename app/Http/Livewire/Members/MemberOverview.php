<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MemberOverview extends Component
{
    public bool $onlyActive = false;
    public string $filterMemberGroup = "";


    public function render()
    {
        /** @var Builder $memberList */
        $memberList = Member::orderBy("lastname")->orderBy("firstname");

        if ($this->onlyActive) {
            $memberList = Member::allActive();
        }

        if($this->filterMemberGroup) {
            $memberList->whereRelation('memberGroups', 'id', intval($this->filterMemberGroup));
        }

        return view('livewire.members.member-overview', [
            'members' => $memberList->get()]
        )->layout('layouts.backend');
    }
}
