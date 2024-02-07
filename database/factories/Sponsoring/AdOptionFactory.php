<?php

namespace Database\Factories\Sponsoring;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\AdOption>
 */
class AdOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(30),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 10,100),
        ];
    }
}
