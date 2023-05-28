<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeThisYear();

        return [
            'title' => fake()->text(50),
            'description' => fake()->text(100),
            'location' => fake()->text(50),
            'dress_code' => fake()->text(50),
            'start' => $start,
            'end' => fake()->dateTimeBetween($start),
            'link' => fake()->url(),
        ];
    }
}
