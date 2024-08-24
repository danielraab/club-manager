<?php

namespace Database\Seeders\Better;

use App\Models\Member;
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
    public int $backerCnt = 0;

    private int $packageCnt = 0;

    public const PERIOD_CNT = 5;

    private const CONTRACT_CNT = 100;

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
        $backerData = [
            [
                'enabled' => true,
                'name' => fake()->company().' en-cl',
                'closed_at' => fake()->dateTime(),
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-cl',
                'closed_at' => fake()->dateTime(),
            ],
            [
                'enabled' => false,
                'name' => fake()->company().' dis-cl',
                'closed_at' => fake()->dateTime(),
            ],
            [
                'enabled' => false,
                'name' => fake()->company().' dis-cl',
                'closed_at' => fake()->dateTime(),
            ],
            [
                'enabled' => false,
                'name' => fake()->company().' dis-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
            [
                'enabled' => true,
                'name' => fake()->company().' en-op',
                'closed_at' => null,
            ],
        ];
        foreach ($backerData as $backerInfo) {
            Backer::factory()->create($backerInfo);
        }
        $this->backerCnt = count($backerData);
    }

    private function addAdOptions(): void
    {
        AdOption::factory()->create([
            'enabled' => true,
            'title' => fake()->text(30).'- en',
        ]);
        AdOption::factory()->create([
            'enabled' => true,
            'title' => fake()->text(30).'- en',
        ]);
        AdOption::factory()->create([
            'enabled' => true,
            'title' => fake()->text(30).'- en',
        ]);
        AdOption::factory()->create([
            'enabled' => false,
            'title' => fake()->text(30).'- dis',
        ]);
        AdOption::factory()->create([
            'enabled' => false,
            'title' => fake()->text(30).'- dis',
        ]);
    }

    private function addPackages(): void
    {
        $packages = [];
        Package::factory()->create([
            'enabled' => true,
            'title' => 'no options en-off',
            'is_official' => true,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => true,
            'title' => 'all flyer en-off',
            'is_official' => true,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => true,
            'title' => 'all transparent en-off',
            'is_official' => true,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => true,
            'title' => 'allincl en-off',
            'is_official' => true,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => true,
            'title' => 'special package en-inoff',
            'is_official' => false,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => false,
            'title' => 'some old package dis-off',
            'is_official' => true,
        ]);
        $packages[] = Package::factory()->create([
            'enabled' => false,
            'title' => 'not used anymore dis-inoff',
            'is_official' => false,
        ]);
        foreach ($packages as $package) {
            /** @var $package Package */
            for ($i = 0; $i < 5; $i++) {
                $package->adOptions()->attach(rand(1, AdOption::query()->count()));
            }
        }
        $this->packageCnt = count($packages) + 1;
    }

    private function addPeriods(): void
    {
        $collection = Period::factory(self::PERIOD_CNT)->create();
        foreach ($collection as $period) {
            /** @var $period Period */
            $ids = range(1, $this->packageCnt);
            for ($i = 0; $i < rand(0, 4); $i++) {
                $period->packages()->attach(array_pop($ids));
            }
        }
    }

    private function addContracts(): void
    {
        $collection = Contract::factory(self::CONTRACT_CNT)->create();
        foreach ($collection as $contract) {
            /** @var $contract Contract */
            if (fake()->boolean(75)) {
                $contract->member()->associate(rand(1, Member::query()->count()))->save();
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
                $contract->package()->associate(rand(1, $this->packageCnt))->save();
            }
        }
    }
}
