<?php

namespace App\Livewire\Sponsoring;

use App\Models\Member;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberBackerAssignment extends Component
{
    public Period $period;

    public Member $member;

    public Collection $previousContracts;
    public array $currentBackers;
    public Collection $openAndCurrentBackers;



    public function mount(Period $period, Member $member, Period $previousPeriod): void
    {
        $this->period = $period;
        $this->member = $member;

        $this->previousContracts = Contract::query()->where('member_id', $this->member->id)
            ->where('period_id', $previousPeriod->id)->get();

        $this->currentBackers = $this->period->contracts()
            ->where('member_id', $this->member->id)
            ->pluck('backer_id')
            ->toArray();
        $this->openAndCurrentBackers = Backer::query()->whereNot(function(Builder $query) {
            $query->whereHas('contracts', function (Builder $query) {
                $query->where('period_id', $this->period->id)
                    ->whereNot('member_id', $this->member->id);
            });
        })->orderBy('name')->get();
    }

    #[On('member-contract-has-changed')]
    public function refreshPost(): void
    {
    }

    public function updateBacker(Backer $backer, $checked): void {
        /** @var Contract $contract */
        $contract = Contract::query()->firstOrNew([
            'period_id' => $this->period->id,
            'backer_id' => $backer->id
        ]);

        if($checked) {
            $contract->member()->associate($this->member);
            $contract->save();
            return;
        }

        $contract->member()->disassociate();
        $contract->save();
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
