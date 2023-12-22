<?php

namespace App\Livewire\Members;

use App\Livewire\MemberFilterTrait;
use App\Models\Member;
use Livewire\Component;

class MemberOverview extends Component
{
    use MemberFilterTrait;

    public function getMembersProperty()
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return $memberList;
    }

    public function render()
    {
        return view('livewire.members.member-overview')->layout('layouts.backend');
    }
}
