<?php

namespace Database\Factories\Sponsoring;

use Database\Seeders\SponsoringSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\Contract>
 */
class ContractFactory extends Factory
{
    private static ?array $availableBackerPeriodCombinations = null;

    public static function initAvailableBackerPeriodCombinations(): void
    {
        if (self::$availableBackerPeriodCombinations === null) {
            self::$availableBackerPeriodCombinations = [];
            for ($i = 1; $i <= SponsoringSeeder::BACKER_CNT; $i++) {
                for ($j = 1; $j <= SponsoringSeeder::PERIOD_CNT; $j++) {
                    self::$availableBackerPeriodCombinations[] = [
                        'backer_id' => $i,
                        'period_id' => $j,
                    ];
                }
            }
            shuffle(self::$availableBackerPeriodCombinations);
        }
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        self::initAvailableBackerPeriodCombinations();

        $refused = fake()->boolean();
        $successful = !$refused && fake()->boolean();
        $contact = null;
        return [
            'info' => fake()->text(60),
            'refused' => $refused ? fake()->dateTime() : null,
            'contract_received' => $successful ? $contact = fake()->dateTime() : null,
            'ad_data_received' => $contact && fake()->boolean() ? fake()->dateTimeBetween($contact) : null,
            'paid' => $contact && fake()->boolean() ? fake()->dateTimeBetween($contact) : null,
            ...array_pop(self::$availableBackerPeriodCombinations)
        ];
    }
}
