<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\AdPlacement;
use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Contract;
use App\Models\Sponsoring\Package;
use App\Models\Sponsoring\Period;
use Illuminate\Database\Seeder;

class SponsoringSeeder extends Seeder
{
    private const COMPANY_NAMES = [
        'Shell', 'Volkswagen', 'Uniper', 'TotalEnergies', 'Glencore', 'BP', 'Stellantis', 'Gazprom', 'Mercedes-Benz', 'Electricite de France',
        'Equinor', 'BMW', 'Enel', 'Eni', 'Allianz', 'E.ON', 'Deutsche', 'Engie', 'Axa', 'DHL',
    ];

    private const COUNRIES = [
        'UK', 'DE', 'DE', 'FR', 'CH', 'UK', 'NL', 'RU', 'DE', 'FR',
        'NO', 'DE', 'IT', 'IT', 'DE', 'DE', 'DE', 'FR', 'FR', 'DE',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addBackers();
        $this->addAdOptions();
        $this->addPackages();
        $this->addPeriods();
        $this->addContracts();
        $this->addAdPlacements();
    }

    private function addBackers(): void
    {
        for ($i = 0; $i < count(self::COMPANY_NAMES) && $i < count(self::COUNRIES); $i++) {
            $attributes = [
                'name' => self::COMPANY_NAMES[$i],
                'country' => self::COUNRIES[$i],
                'email' => str_replace(' ', '', self::COMPANY_NAMES[$i]).'@example.com',
            ];

            switch ($i) {
                case 4:
                    $attributes['contact_person'] = 'Some Contact Person';
                    break;
                case 5:
                case 6:
                case 7:
                    $attributes['email'] = null;
                    break;
                case 8:
                    $attributes['website'] = 'www.example.com';
                    break;
                case 9:
                    $attributes['street'] = 'Teststr. 123';
                    $attributes['zip'] = '1234';
                    $attributes['city'] = 'Testcity';
                    break;
                case 10:
                    $attributes['vat'] = '12354123';
                    break;
                case 11:
                    $attributes['info'] = 'Some important information';
                    break;
                case 12:
                    $attributes['closed_at'] = now()->subMonths(5);
                    break;
                case 13:
                    $attributes['closed_at'] = now()->subMonths(8);
                    break;
                case 14:
                case 15:
                case 16:
                case 17:
                    $attributes['enabled'] = false;
                    break;
            }

            Backer::query()->create($attributes);
        }
    }

    private function addAdOptions(): void
    {
        AdOption::query()->insert([
            [
                'id' => 1,
                'title' => 'Konzerteinladung',
                'price' => 123.20,
                'description' => null,
                'enabled' => true,
            ],
            [
                'id' => 2,
                'title' => 'Konzerteinladung 2',
                'price' => 123.20,
                'description' => null,
                'enabled' => true,
            ],
            [
                'id' => 3,
                'title' => 'Zeitung',
                'price' => 150.0,
                'description' => null,
                'enabled' => true,
            ],
            [
                'id' => 4,
                'title' => 'Ball',
                'description' => 'Some descriptive description.',
                'enabled' => true,
                'price' => 200.0,
            ],
            [
                'id' => 5,
                'title' => 'Website',
                'description' => null,
                'enabled' => true,
                'price' => 50.0,
            ],
            [
                'id' => 6,
                'title' => 'Beamer',
                'description' => null,
                'enabled' => false,
                'price' => 50.0,
            ],
        ]);
    }

    private function addPackages(): void
    {
        Package::query()->create([
            'id' => 1,
            'enabled' => true,
            'title' => 'All inclusive',
            'description' => 'all available packages',
            'is_official' => true,
            'price' => 500,
        ])->adOptions()->sync([1, 2, 3, 4, 5]);
        Package::query()->create([
            'id' => 2,
            'enabled' => true,
            'title' => 'Minimal',
            'description' => 'The smallest version of all packages',
            'is_official' => true,
            'price' => 50,
        ])->adOptions()->sync([5]);
        Package::query()->create([
            'id' => 3,
            'enabled' => true,
            'title' => 'The Special one',
            'description' => 'a special one, is not official',
            'is_official' => false,
            'price' => 100,
        ])->adOptions()->sync([3, 5]);
        Package::query()->create([
            'id' => 4,
            'enabled' => false,
            'title' => 'Too old',
            'description' => null,
            'is_official' => true,
            'price' => 200,
        ])->adOptions()->sync([1, 2, 6]);
        Package::query()->create([
            'id' => 5,
            'enabled' => true,
            'title' => 'Konzerte',
            'description' => null,
            'is_official' => true,
            'price' => 300,
        ])->adOptions()->sync([1, 2]);
    }

    private function addPeriods(): void
    {
        Period::query()->create([
            'id' => 1,
            'title' => now()->subYear()->format('Y'),
            'description' => 'the past one',
            'start' => now()->subYear()->firstOfYear(),
            'end' => now()->subYear()->lastOfYear(),
        ])->packages()->sync([2, 4, 5]);
        Period::query()->create([
            'id' => 2,
            'title' => now()->format('Y'),
            'description' => 'the current one',
            'start' => now()->firstOfYear(),
            'end' => now()->lastOfYear(),
        ])->packages()->sync([1, 2, 3, 5]);
        Period::query()->create([
            'id' => 3,
            'title' => now()->addYear()->format('Y'),
            'description' => 'the future one',
            'start' => now()->addYear()->firstOfYear(),
            'end' => now()->addYear()->lastOfYear(),
        ])->packages()->sync([1, 2, 5]);
    }

    private function addContracts(): void
    {
        $start1 = now()->subYear()->firstOfYear();
        for ($i = 0; $i < 15; $i++) {
            Contract::query()->create([
                'period_id' => 1,
                'backer_id' => ($i % count(self::COMPANY_NAMES)) + 1,
                'member_id' => ($i % count(MemberSeeder::FIRSTNAMES) / 2) + 5,
                'package_id' => ($i % 5) + 1,
                'contract_received' => $start1->addWeeks(2),
                'paid' => $start1->clone()->addWeek(),
            ]);
        }
        for ($i = 15; $i < count(self::COMPANY_NAMES); $i++) {
            Contract::query()->create([
                'period_id' => 1,
                'backer_id' => ($i % count(self::COMPANY_NAMES)) + 1,
                'member_id' => null,
                'package_id' => null,
                'refused' => $start1->addWeeks(2),
            ]);
        }

        $start2 = now()->firstOfYear();
        for ($i = 0; $i < 10; $i++) {
            Contract::query()->create([
                'period_id' => 2,
                'backer_id' => ($i % count(self::COMPANY_NAMES)) + 1,
                'member_id' => ($i % count(MemberSeeder::FIRSTNAMES) / 2) + 5,
                'package_id' => ($i % 5) + 1,
                'contract_received' => $start2->addWeeks(2),
                'paid' => $start2->clone()->addWeek(),
            ]);
        }
        for ($i = 10; $i < 15; $i++) {
            Contract::query()->create([
                'period_id' => 2,
                'backer_id' => ($i % count(self::COMPANY_NAMES)) + 1,
                'member_id' => ($i % count(MemberSeeder::FIRSTNAMES) / 2) + 5,
            ]);
        }

        $start3 = now();
        for ($i = 0; $i < 5; $i++) {
            Contract::query()->create([
                'period_id' => 3,
                'backer_id' => ($i % count(self::COMPANY_NAMES)) + 1,
                'member_id' => ($i % count(MemberSeeder::FIRSTNAMES) / 2) + 5,
                'package_id' => ($i % 5) + 1,
                'contract_received' => $start3->subDays(4),
            ]);
        }
    }

    private function addAdPlacements(): void
    {
        $activeContracts = Contract::query()
            ->whereNotNull('package_id')
            ->where('period_id', 1)
            ->get();

        foreach ($activeContracts as $contract) {
            /** @var Contract $contract */
            $options = $contract->package->adOptions;
            foreach ($options as $option) {
                AdPlacement::query()->create([
                    'contract_id' => $contract->id,
                    'ad_option_id' => $option->id,
                    'done' => true,
                ]);
            }
        }

        $activeContracts = Contract::query()
            ->whereNotNull('package_id')
            ->where('period_id', 2)
            ->get();

        foreach ($activeContracts as $contract) {
            /** @var Contract $contract */
            $options = $contract->package->adOptions;
            foreach ($options as $option) {
                if ($option->id % 3 === 0) {
                    break;
                }
                AdPlacement::query()->create([
                    'contract_id' => $contract->id,
                    'ad_option_id' => $option->id,
                    'done' => true,
                ]);
            }
        }
    }
}
