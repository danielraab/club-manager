<?php

namespace Database\Seeders;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SponsoringSeeder extends Seeder
{
    private const AD_OPTION_CNT = 10;
    private const BACKER_CNT = 100;
    private const PACKAGE_CNT = 10;
    private const PERIOD_CNT = 5;
    private const CONTRACT_CNT = 200;

    private User $sponsoringShow;
    private User $sponsoringEdit;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addUsers();
        $this->addBackers();
        $this->addAdOptions();
        $this->addPackages();
        $this->addPeriods();
        $this->addContracts();
    }

    private function addUsers(): void
    {
        $this->sponsoringShow = User::factory()->create([
            'name' => 'Sponsoring Show',
            'email' => 'sponsoringShow@draab.at',
            'password' => Hash::make('sponsoringShow'),
        ]);
        $this->sponsoringShow->userPermissions()
            ->attach(Contract::SPONSORING_SHOW_PERMISSION);

        $this->sponsoringEdit = User::factory()->create([
            'name' => 'Sponsoring Edit',
            'email' => 'sponsoringEdit@draab.at',
            'password' => Hash::make('sponsoringEdit'),
        ]);
        $this->sponsoringEdit->userPermissions()
            ->attach(Contract::SPONSORING_EDIT_PERMISSION);
    }

    private function addBackers(): void
    {
        Backer::factory(self::BACKER_CNT)->create();
    }

    private function addAdOptions(): void
    {
        AdOption::factory(self::AD_OPTION_CNT)->create();
    }

    private function addPackages(): void
    {
        $collection = Package::factory(self::PACKAGE_CNT)->create();
        $first = true;
        foreach ($collection as $package) {
            if($first) {
                $first = false;
                continue;
            }
            /** @var $package Package */
            for ($i = 0; $i < 5; $i++) {
                $package->adOptions()->attach(rand(1, self::AD_OPTION_CNT));
            }
        }
    }

    private function addPeriods(): void
    {
        $collection = Period::factory(self::PERIOD_CNT)->create();
        foreach ($collection as $period) {
            /** @var $period Period */
            for ($i = 0; $i < 5; $i++) {
                $period->packages()->attach(rand(1, self::PACKAGE_CNT));
            }
        }
    }

    private function addContracts(): void
    {
        $collection = Contract::factory(self::CONTRACT_CNT)->create();
        foreach ($collection as $contract) {
            /** @var $contract Contract */
            $contract->period()->associate(rand(1, self::PERIOD_CNT))->save();
            $contract->backer()->associate(rand(1, self::BACKER_CNT))->save();
            if (fake()->boolean(95)) {
                $contract->member()->associate(rand(1, MemberSeeder::$memberCnt))->save();
            } else {
                // member receded contract, must be assigned to new member
                $contract->refused = null;
                $contract->contract_received = null;
                $contract->ad_data_received = null;
                $contract->paid = null;
                $contract->save();
                continue;
            }
            if ($contract->refused === null &&
                ($contract->contract_received || $contract->ad_data_received || $contract->paid)) {
                $contract->package()->associate(rand(1, self::PACKAGE_CNT))->save();
            }
        }
    }
}
