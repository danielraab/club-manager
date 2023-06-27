<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "firstname" => fake()->firstName(),
            "lastname" => fake()->lastName(),
            "title_pre" => fake()->title(),
            "title_post" => fake()->title(),
            "birthday" => fake()->dateTimeThisCentury(now()->subYear()),
            "phone" => fake()->phoneNumber(),
            "email" => fake()->email(),
            "street" => fake()->streetAddress(),
            "zip" => fake()->numberBetween(1000, 99999),
            "city" => fake()->city(),
            "entrance_date" => $entrance = fake()->dateTimeBetween(),
            "leaving_date" => fake()->dateTimeBetween($entrance)
        ];
    }
}
