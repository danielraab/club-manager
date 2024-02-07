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
        $refused = fake()->boolean();
        $successful = !$refused && fake()->boolean();
        $contact = null;
        return [
            'info' => fake()->text(60),
            'refused' => $refused ? fake()->dateTime() : null,
            'contract_received' => $successful ? $contact = fake()->dateTime() : null,
            'ad_data_received' => $contact && fake()->boolean() ? fake()->dateTimeBetween($contact) : null,
            'paid' => $contact && fake()->boolean() ? fake()->dateTimeBetween($contact) : null,
            'period_id' => 1,
            'backer_id' => 1
        ];
    }
}
