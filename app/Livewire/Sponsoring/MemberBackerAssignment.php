<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Models\Member;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use App\Notifications\SponsoringMemberPeriodSummary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class MemberBackerAssignment extends Component
{
    public bool $changed = false;

    public Period $period;

    public Member $member;

    public Collection $previousContracts;

    public Collection $openAndCurrentBackers;
    public Collection $currentContracts;

    public function mount(Period $period, Member $member, Period $previousPeriod = null): void
    {
        $this->period = $period;
        $this->member = $member;

        $this->previousContracts = Collection::empty();
        if ($previousPeriod) {
            $this->previousContracts = Contract::query()->where('member_id', $this->member->id)
                ->where('period_id', $previousPeriod->id)->get();
        }

        $this->calculateOpenAndCurrentBackers();
    }

    public function calculateOpenAndCurrentBackers(): void
    {
        $this->currentContracts = $this->period->contracts()
            ->where('member_id', $this->member->id)->get();

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
        Log::debug('member-contract-has-changed triggered');
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

    public function sendSummaryMailToMember(): void
    {
        $currentContracts = $this->period->contracts()->where('member_id', $this->member->id)->get();
        if ($currentContracts->isEmpty()) {
            NotificationMessage::addWarningNotificationMessage(
                __('No active contracts available to send.')
            );

            return;
        }

        $this->member->notify(new SponsoringMemberPeriodSummary($this->period, $currentContracts));

        Log::info('Sponsoring summary mail sent to member.', [auth()->user(), $this->member]);
        NotificationMessage::addSuccessNotificationMessage(
            __('The summary mail has been successfully sent to :mail.', ['mail' => $this->member->email])
        );
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        dd($this->currentContracts);
        return view('livewire.sponsoring.member-backer-assignment');
    }
}
