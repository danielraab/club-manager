<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\AdPlacement;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;

class PeriodAdOptionOverview extends Controller
{
    private Period $period;

    private array $adOptionList;

    public function index(Period $period)
    {
        $this->period = $period;

        $this->listAdOptionsFromPeriod();
        $this->fillAdOptionListWithBackers();

        $hasPlacementEditPermission = \Illuminate\Support\Facades\Auth::user()->hasPermission(
            \App\Models\Sponsoring\AdPlacement::SPONSORING_EDIT_AD_PLACEMENTS,
            \App\Models\Sponsoring\Contract::SPONSORING_EDIT_PERMISSION
        );

        return view('sponsoring.period-ad-option-overview', [
            'period' => $period,
            'adOptionList' => $this->adOptionList,
            'hasPlacementEditPermission' => $hasPlacementEditPermission
        ]);
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

    private function addAdOptionFromPackage(Package $package, Contract $contract, Backer $backer): void {
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
