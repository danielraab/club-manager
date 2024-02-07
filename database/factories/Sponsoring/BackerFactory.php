<?php

namespace Database\Factories\Sponsoring;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\Backer>
 */
class BackerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'contact_person' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'street' => fake()->streetAddress(),
            'zip' => fake()->numberBetween(1000, 99999),
            'city' => fake()->city(),
            'info' => fake()->text()
        ];
    }
}
