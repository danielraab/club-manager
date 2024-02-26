<?php

namespace App\Http\Controllers\Sponsoring;

use App\Http\Controllers\Controller;
use App\Models\Sponsoring\AdOption;
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

        return view('sponsoring.period-ad-option-overview', [
            "period" => $period,
            "adOptionList" => $this->adOptionList
        ]);
    }

    private function listAdOptionsFromPeriod(): void
    {
        $packages = $this->period->packages()->with("adOptions")->get();
        foreach ($packages as $package) {
            /** @var Package $package */
            foreach ($package->adOptions()->get() as $adOption) {
                /** @var AdOption $adOption */
                $this->adOptionList[$adOption->id] = ["adOption" => $adOption, "backerList" => []];
            }
        }
    }

    private function fillAdOptionListWithBackers(): void
    {

        $contracts = $this->period->contracts()->with(["backer", "package"])->get();
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
                foreach ($package->adOptions()->get() as $adOption) {
                    $this->adOptionList[$adOption->id]["backerList"][] = [
                        "backer" => $backer,
                        "package" => $package
                    ];
                }
            }
        }
    }
}
