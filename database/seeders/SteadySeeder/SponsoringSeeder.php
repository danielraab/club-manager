<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\Sponsoring\AdOption;
use App\Models\Sponsoring\Backer;
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
                case 0:
                case 1:
                case 2:
                case 3:
                    $attributes['enabled'] = false;
                    break;
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
            }

            Backer::query()->create($attributes);
        }
    }

    private function addAdOptions(): void
    {
        AdOption::query()->insert([
            [
                'title' => 'Konzerteinladung',
                'price' => 123.20,
                'description' => null,
                'enabled' => false,
            ],
            [
                'title' => 'Konzerteinladung 2',
                'price' => 123.20,
                'description' => null,
                'enabled' => false,
            ],
            [
                'title' => 'Zeitung',
                'price' => 150.0,
                'description' => null,
                'enabled' => false,
            ],
            [
                'title' => 'Ball',
                'description' => 'Some descriptive description.',
                'enabled' => false,
                'price' => 200.0,
            ],
            [
                'title' => 'Website',
                'description' => null,
                'enabled' => false,
                'price' => 50.0,
            ],
        ]);
    }

    private function addPackages(): void
    {
        Package::query()->insert([
            [
                'enabled' => true,
                'title' => 'All inclusive',
                'description' => 'all available packages',
                'is_official' => true,
                'price' => 500,
            ],
            [
                'enabled' => true,
                'title' => 'Minimal',
                'description' => 'The smallest version of all packages',
                'is_official' => true,
                'price' => 50,
            ],
            [
                'enabled' => true,
                'title' => 'The Special one',
                'description' => 'a special one, is not official',
                'is_official' => false,
                'price' => 100,
            ],
            [
                'enabled' => false,
                'title' => 'Too old',
                'description' => null,
                'is_official' => true,
                'price' => 200,
            ],
            [
                'enabled' => true,
                'title' => 'Konzerte',
                'description' => null,
                'is_official' => true,
                'price' => 300,
            ],
        ]);

        //TODO assign add options
    }

    private function addPeriods(): void
    {
        Period::query()->insert([
            [
                'title' => (string) now()->subYear()->format('YYYY'),
                'description' => 'the past one',
                'start' => now()->subYear()->firstOfYear(),
                'end' => now()->subYear()->lastOfYear(),
            ],
            [
                'title' => (string) now()->format('YYYY'),
                'description' => 'the current one',
                'start' => now()->firstOfYear(),
                'end' => now()->lastOfYear(),
            ],
            [
                'title' => (string) now()->addYear()->format('YYYY'),
                'description' => 'the future one',
                'start' => now()->addYear()->firstOfYear(),
                'end' => now()->addYear()->lastOfYear(),
            ],
        ]);

        //TODO assign packages
    }

    private function addContracts(): void
    {
        //TODO
    }

    private function addAdPlacements(): void
    {
        //TODO
    }
}
