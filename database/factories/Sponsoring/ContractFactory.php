<?php

namespace Database\Factories\Sponsoring;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'info' => fake()->text(60),
            'is_refused' => fake()->boolean(),
            'is_contract_received' => fake()->boolean(),
            'is_ad_data_received' => fake()->boolean(),
            'is_paid' => fake()->boolean(),
        ];
    }
}
