<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\AttendancePoll;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceSeeder extends Seeder
{
    public mixed $attendanceEdit;

    public mixed $attendancePollEdit;

    public $attendancePollCollection;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addUsers();
        $this->addAttendance();
        $this->addAttendancePoll();
    }

    private function addUsers(): void
    {
        $attendanceShow = \App\Models\User::factory()->create([
            'name' => 'Attendance Show User',
            'email' => 'attendanceShow@draab.at',
            'password' => Hash::make('attendanceShow'),
        ]);
        $attendanceShow->userPermissions()->attach(Attendance::ATTENDANCE_SHOW_PERMISSION);

        $this->attendanceEdit = \App\Models\User::factory()->create([
            'name' => 'Attendance Edit User',
            'email' => 'attendanceEdit@draab.at',
            'password' => Hash::make('attendanceEdit'),
        ]);
        $this->attendanceEdit->userPermissions()->attach(Attendance::ATTENDANCE_EDIT_PERMISSION);

        $attendancePollShow = \App\Models\User::factory()->create([
            'name' => 'Attendance Poll Show User',
            'email' => 'attendancePollShow@draab.at',
            'password' => Hash::make('attendancePollShow'),
        ]);
        $attendancePollShow->userPermissions()->attach(AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION);

        $this->attendancePollEdit = \App\Models\User::factory()->create([
            'name' => 'Attendance Poll Edit User',
            'email' => 'attendancePollEdit@draab.at',
            'password' => Hash::make('attendancePollEdit'),
        ]);
        $this->attendancePollEdit->userPermissions()->attach(AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION);
    }

    public function addAttendance()
    {
        $coll = Attendance::factory(1000)->create();
    }

    public function addAttendancePoll()
    {
        $this->attendancePollCollection = AttendancePoll::factory(10)->create();
        $this->attendancePollCollection->each(function (AttendancePoll $attendancePoll) {
            for ($i = 0; $i < fake()->numberBetween(1, 5); $i++) {
                $attendancePoll->events()->attach(fake()->numberBetween(1, EventSeeder::$eventCnt));
            }
        });
    }
}
