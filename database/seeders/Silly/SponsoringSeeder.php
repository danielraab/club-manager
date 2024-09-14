<?php

namespace Database\Seeders\Silly;

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

    public const BACKER_CNT = 100;

    private const PACKAGE_CNT = 10;

    public const PERIOD_CNT = 5;

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
            if ($first) {
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
            $packageIds = range(1, rand(1, self::PACKAGE_CNT));
            /** @var $period Period */
            foreach ($packageIds as $id) {
                $period->packages()->attach($id);
            }
        }
    }

    private function addContracts(): void
    {
        $contracts = [];
        for ($i = 1; $i <= self::PERIOD_CNT; $i++) {
            for ($j = 1; $j <= self::BACKER_CNT; $j++) {
                if (fake()->boolean()) {
                    $contracts[] = Contract::factory()->create([
                        'period_id' => $i,
                        'backer_id' => $j,
                    ]);
                }
            }
        }

        foreach ($contracts as $contract) {
            /** @var $contract Contract */
            if (fake()->boolean(75)) {
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
