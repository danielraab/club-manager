<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PeriodBackerOverview extends Component
{
    public bool $hasEditPermission = false;
    public Period $period;
    public string $previousUrl;

    public function mount(Period $period): void
    {
        $this->hasEditPermission = Auth::user()->hasPermission(Contract::SPONSORING_EDIT_PERMISSION);
        $this->period = $period;
        $this->previousUrl = url()->previous();
    }

    public function generateAllContracts(): void
    {
        if (!$this->hasEditPermission) return;
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
        session()->flash('createdMessage', __(':cnt contracts created.', ["cnt" => $cnt]));
    }

    public function getContractBackerIdList(): array
    {
        return Contract::query()->where("period_id", $this->period->id)
            ->pluck("backer_id")->toArray();
    }

    public function createContract(int $backerId): void
    {
        if (!$this->hasEditPermission) return;
        $contract = new Contract();
        $contract->backer()->associate($backerId);
        $contract->period()->associate($this->period->id);
        $contract->save();
    }

    private function getContractsOfPeriod(Backer $backer): null|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $backer->contracts()->where("period_id", $this->period->id)->first();
    }

    public function render()
    {
        $backerList = [];
        /** @var Backer $backer */
        foreach (Backer::query()->with("contracts")->orderBy("name")->get() as $backer) {
            /** @var Contract $contract */
            $contract = $this->getContractsOfPeriod($backer);
            if (!$backer->enabled) {
                if ($contract) $backerList["disabled"][] = ["backer" => $backer, "contract" => $contract];
            } else if ($backer->closed_at) {
                if ($contract) $backerList["closed"][] = ["backer" => $backer, "contract" => $contract];
            } else {
                $backerList["enabled"][] = ["backer" => $backer, "contract" => $contract];
            }
        }
        return view('livewire.sponsoring.period-backer-overview', [
            "backerList" => $backerList
        ])->layout('layouts.backend');
    }
}
