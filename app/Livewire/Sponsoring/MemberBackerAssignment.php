<?php

namespace App\Livewire\Sponsoring;

use App\Models\Member;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class MemberBackerAssignment extends Component
{
    public bool $changed = false;
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
        $this->calculateOpenAndCurrentBackers();
    }

    /**
     * @return void
     */
    public function calculateOpenAndCurrentBackers(): void
    {
        $this->openAndCurrentBackers = Backer::query()->whereNot(function (Builder $query) {
            $query->whereHas('contracts', function (Builder $query) {
                $query->where('period_id', $this->period->id)
                    ->whereNot('member_id', $this->member->id);
            });
        })->orderBy('name')->get();
    }

    #[On('member-contract-has-changed')]
    public function refreshComponent(): void
    {
        $this->calculateOpenAndCurrentBackers();
    }

    #[Renderless]
    public function updateBacker(Backer $backer, $checked): void
    {
        /** @var Contract $contract */
        $contract = Contract::query()->where([
            'period_id' => $this->period->id,
            'backer_id' => $backer->id,
        ])->first();

        if ($checked) {
            if (! $contract) {
                $contract = new Contract();
            }
            $contract->period()->associate($this->period);
            $contract->backer()->associate($backer);
            $contract->member()->associate($this->member);
            $contract->save();

            return;
        }

        if ($contract) {
            $contract->member()->disassociate();
            $contract->save();
        }
    }

    public function render()
    {
        return view('livewire.sponsoring.member-backer-assignment');
    }

}
