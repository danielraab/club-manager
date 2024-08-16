<?php

namespace App\Livewire\Sponsoring;

use App\Models\Member;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberBackerAssignment extends Component
{
    public Period $period;

    public Member $member;

    public Collection $previousContracts;
    public Collection $currentContracts;
    public Collection $openContracts;



    public function mount(Period $period, Member $member, Period $previousPeriod): void
    {
        $this->period = $period;
        $this->member = $member;

        $this->previousContracts = Contract::query()->where('member_id', $this->member->id)
            ->where('period_id', $previousPeriod->id)->get();
        $this->currentContracts = $this->period->contracts()->where('member_id', $this->member->id)->get();
        $this->openContracts = $this->period->contracts()->whereNull('member_id')->get();

        /**
         * TODO: get a list of backers for a member (no contract, not selected or selected)
         * backers should be sorted
         * info if a backer has a selcted contract from the member
         */
    }

    #[On('member-contract-ass-changed')]
    public function refreshPost(): void
    {
    }

    public function assignMember(Contract $contract): void
    {
        $contract->member()->associate($this->member);
        $contract->save();
        $this->dispatch('member-contract-ass-changed');
    }

    public function unassignMember(Contract $contract): void
    {
        $contract->member()->disassociate();
        $contract->save();
        $this->dispatch('member-contract-ass-changed');
    }

    public function render()
    {
        return view('livewire.sponsoring.member-backer-assignment');
    }
}
