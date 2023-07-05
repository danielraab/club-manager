<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendancePollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'enabled' => fake()->boolean(),
            'allow_anonymous_vote' => fake()->boolean(),
            'closing_at' => fake()->dateTimeBetween(
                now()->subWeeks(2),
                now()->addWeeks(4)
            ),
        ];
    }
}
