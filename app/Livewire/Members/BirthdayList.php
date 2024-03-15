<?php

namespace App\Livewire\Members;

use App\Livewire\MemberFilterTrait;
use App\Models\Member;
use Livewire\Component;

class BirthdayList extends Component
{
    use MemberFilterTrait;

    public function mount(): void
    {
        $this->initFilter();
    }

    public function render()
    {
        $filter = $this->getMemberFilter();
        $missingBirthdayList = Member::getAllFiltered($filter)
            ->whereNull('birthday')
            ->orderBy('lastname')->get();
        $memberList = Member::getAllFiltered($filter)->whereNotNull('birthday')->get()
            ->sort(function ($memberA, $memberB) {
                return strcmp($memberA->birthday->isoFormat('MM-DD'), $memberB->birthday->isoFormat('MM-DD'));
            });

        return view('livewire.members.member-birthday-list', [
            'missingBirthdayList' => $missingBirthdayList,
            'members' => $memberList,
        ])->layout('layouts.backend');
    }
}
