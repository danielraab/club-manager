<?php

namespace App\Livewire\Members;

use App\Livewire\MemberFilterTrait;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberOverview extends Component
{
    use MemberFilterTrait;

    public function mount()
    {
        $this->initFilter();
    }

    public function togglePausedState(Member $member): void
    {
        $member->paused = ! $member->paused;
        $member->lastUpdater()->associate(Auth::user());
        $member->save();
    }

    /**
     * method to make a property available in template: $this->members
     */
    public function getMembersProperty(): Builder
    {
        $memberList = Member::getAllFiltered($this->getMemberFilter());

        return $memberList;
    }

    public function render()
    {
        return view('livewire.members.member-overview')->layout('layouts.backend');
    }
}
