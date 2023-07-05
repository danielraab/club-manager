<?php

namespace Database\Factories;

use App\Models\Attendance;
use Database\Seeders\EventSeeder;
use Database\Seeders\MemberSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => fake()->numberBetween(1, EventSeeder::$eventCnt),
            'member_id' => fake()->numberBetween(1, MemberSeeder::$memberCnt),
            'poll_status' => fake()->randomElement(Attendance::AVAILABLE_POLL_STATUS_LIST),
            'final_status' => fake()->randomElement(Attendance::AVAILABLE_FINAL_STATUS_LIST),
        ];
    }
}
