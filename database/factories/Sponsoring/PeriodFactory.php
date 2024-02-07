<?php

namespace Database\Factories\Sponsoring;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sponsoring\Period>
 */
class PeriodFactory extends Factory
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
            'start' => $start = fake()->dateTimeBetween(),
            'end' => fake()->dateTimeBetween($start),
        ];
    }
}
