<?php

namespace App\Livewire\Sponsoring;

use App\Facade\NotificationMessage;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PeriodBackerOverview extends Component
{
    public bool $hasEditPermission = false;

    public Period $period;
    private \Illuminate\Database\Eloquent\Collection $openContractWithMember;

    public function mount(Period $period): void
    {
        $this->hasEditPermission = Auth::user()->hasPermission(Contract::SPONSORING_EDIT_PERMISSION);
        $this->period = $period;

        $this->openContractWithMember = $this->period->contracts()
            ->whereNotNull('member_id')
            ->whereNull('refused')
            ->whereNull('contract_received')
            ->whereNull('paid')
            ->with(['member', 'backer'])->get();
    }

    public function generateAllContracts(): void
    {
        if (! $this->hasEditPermission) {
            return;
        }
        $cnt = 0;
        $contractBackerIdArr = $this->getContractBackerIdList();
        foreach (Backer::allActive()->get() as $backer) {
            /** @var $backer Backer */
            if (in_array($backer->id, $contractBackerIdArr)) {
                continue;
            }

            $this->createContract($backer->id);
            $cnt++;
        }
        if ($cnt) {
            Log::info("$cnt contracts created", [auth()->user()]);
        }
        NotificationMessage::addNotificationMessage(
            new Item(__(':cnt contracts created.', ['cnt' => $cnt]), ItemType::SUCCESS)
        );
    }

    public function getContractBackerIdList(): array
    {
        return Contract::query()->where('period_id', $this->period->id)
            ->pluck('backer_id')->toArray();
    }

    public function createContract(int $backerId): void
    {
        if (! $this->hasEditPermission) {
            return;
        }
        $contract = new Contract();
        $contract->backer()->associate($backerId);
        $contract->period()->associate($this->period->id);
        $contract->save();
    }

    private function getContractsOfPeriod(Backer $backer): null|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $backer->contracts()->where('period_id', $this->period->id)->first();
    }

    public function sendNotificationMail(): void {
        //TODO implement
    }

    public function render()
    {
        $backerList = [
            'enabled' => [],
            'disabled' => [],
            'closed' => [],
        ];
        /** @var Backer $backer */
        foreach (Backer::query()->with('contracts')->orderBy('name')->get() as $backer) {
            /** @var Contract $contract */
            $contract = $this->getContractsOfPeriod($backer);
            if (! $backer->enabled) {
                if ($contract) {
                    $backerList['disabled'][] = ['backer' => $backer, 'contract' => $contract];
                }
            } elseif ($backer->closed_at) {
                if ($contract) {
                    $backerList['closed'][] = ['backer' => $backer, 'contract' => $contract];
                }
            } else {
                $backerList['enabled'][] = ['backer' => $backer, 'contract' => $contract];
            }
        }

        return view('livewire.sponsoring.period-backer-overview', [
            'backerList' => $backerList,
        ])->layout('layouts.backend');
    }
}
