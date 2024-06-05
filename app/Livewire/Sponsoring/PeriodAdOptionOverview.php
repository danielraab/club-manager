<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\AdPlacement;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use Livewire\Component;

class PeriodAdOptionOverview extends Component
{
    public Period $period;

    public array $adOptionList;

    public function mount(Period $period)
    {
        $this->period = $period;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->listAdOptionsFromPeriod();
        $this->fillAdOptionListWithBackers();

        return view('livewire.sponsoring.period-ad-option-overview')->layout('layouts.backend');
    }

    private function listAdOptionsFromPeriod(): void
    {
        $packages = $this->period->packages()->with('adOptions')->get();
        foreach ($packages as $package) {
            /** @var Package $package */
            foreach ($package->adOptions()->get() as $adOption) {
                /** @var AdOption $adOption */
                $this->adOptionList[$adOption->id] = ['adOption' => $adOption, 'backerList' => []];
            }
        }
    }

    private function fillAdOptionListWithBackers(): void
    {
        $contracts = $this->period->contracts()->with(['backer', 'package'])->get();
        foreach ($contracts as $contract) {
            /**
             * @var $contract Contract
             * @var $backer Backer
             * @var $package Package
             * @var $adOption AdOption
             */
            $backer = $contract->backer()->first();
            $package = $contract->package()->first();
            if ($backer && $package) {
                $this->addAdOptionFromPackage($package, $contract, $backer);
            }
        }
    }

    private function addAdOptionFromPackage(Package $package, Contract $contract, Backer $backer): void
    {
        foreach ($package->adOptions()->get() as $adOption) {
            if (! isset($this->adOptionList[$adOption->id])) {
                $this->adOptionList[$adOption->id] = ['adOption' => $adOption, 'backerList' => [], 'isNotInPackages' => true];
            }
            if (! isset($this->adOptionList[$adOption->id]['backerList'][$backer->id])) {
                /** @var AdPlacement $adPlacement */
                $adPlacement = AdPlacement::find($contract->id, $adOption->id);
                $this->adOptionList[$adOption->id]['backerList'][$backer->id] = [
                    'contractId' => $contract->id,
                    'backer' => $backer,
                    'packageTitle' => $package->title,
                    'adPlacementDone' => $adPlacement?->done ?: false,
                ];
            }
        }
    }
}
