<?php

namespace Database\Seeders\Minimal;

use App\Models\Member;
use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Seeder;

class SponsoringSeeder extends Seeder
{
    private AdOption|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $adOption;

    private Backer|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $backer;

    private Package|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $package;

    private Period|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $period;

    private Backer|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $backer2;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addBacker();
        $this->addAdOption();
        $this->addPackage();
        $this->addPeriod();
        $this->addContract();
    }

    private function addBacker(): void
    {
        $this->backer = Backer::factory()->create();
        $this->backer2 = Backer::factory()->create();
    }

    private function addAdOption(): void
    {
        $this->adOption = AdOption::factory()->create();
    }

    private function addPackage(): void
    {
        $this->package = Package::factory()->create();
        $this->package->adOptions()->attach($this->adOption);
    }

    private function addPeriod(): void
    {
        $this->period = Period::factory()->create();
        $this->period->packages()->attach($this->package);
    }

    private function addContract(): void
    {
        $contract1 = Contract::factory()->create();
        $contract1->member()->associate(Member::query()->first());
        $contract1->package()->associate($this->package)->save();
        $contract1->refused = null;
        $contract1->contract_received = fake()->dateTime('-14 days');
        $contract1->ad_data_received = fake()->dateTime('-10 days');
        $contract1->paid = fake()->dateTime('-4 days');
        $contract1->save();

        $contract2 = Contract::factory()->create();
        $contract2->refused = null;
        $contract2->contract_received = null;
        $contract2->ad_data_received = null;
        $contract2->paid = null;
        $contract2->save();
    }
}
