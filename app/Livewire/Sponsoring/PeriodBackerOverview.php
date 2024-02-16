<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PeriodBackerOverview extends Component
{
    public Period $period;
    public string $previousUrl;

    public function mount(Period $period): void
    {
        $this->period = $period;
        $this->previousUrl = url()->previous();
    }

    public function generateAllContracts(): void
    {
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
        $contract = new Contract();
        $contract->backer()->associate($backerId);
        $contract->period()->associate($this->period->id);
        $contract->save();
    }

    public function render()
    {
        return view('livewire.sponsoring.period-backer-overview')->layout('layouts.backend');
    }
}
