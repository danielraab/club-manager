<?php

namespace Database\Factories;

use App\Models\Attendance;
use Database\Seeders\Silly\EventSeeder;
use Database\Seeders\Silly\MemberSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    private static ?array $availableEventMemberCombinations = null;

    public static function initAvailableEventMemberCombinations(): void
    {
        if (self::$availableEventMemberCombinations === null) {
            self::$availableEventMemberCombinations = [];
            for ($i = 1; $i <= EventSeeder::$eventCnt; $i++) {
                for ($j = 1; $j <= MemberSeeder::$memberCnt; $j++) {
                    self::$availableEventMemberCombinations[] = [
                        'event_id' => $i,
                        'member_id' => $j,
                    ];
                }
            }
            shuffle(self::$availableEventMemberCombinations);
        }
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::initAvailableEventMemberCombinations();

        return [
            ...array_pop(self::$availableEventMemberCombinations),
            'poll_status' => fake()->randomElement([null, ...Attendance::AVAILABLE_POLL_STATUS_LIST]),
            'attended' => fake()->randomElement([null, true, false]),
        ];
    }
}
