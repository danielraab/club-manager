<?php

namespace Database\Factories\Sponsoring;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enabled' => fake()->boolean(90),
            'title' => fake()->text(30),
            'description' => fake()->text(),
            'is_official' => fake()->boolean(),
            'price' => fake()->randomFloat(2, 50, 500),
        ];
    }
}
