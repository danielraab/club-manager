<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\Attendance;
use App\Models\AttendancePoll;
use App\Models\Member;
use App\Models\News;
use App\Models\Sponsoring\Contract;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function getData(): array
    {
        return [
            [
                'attributes' => [
                    'id' => 1,
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'password' => Hash::make('admin'),
                ],
                'permissions' => [
                    UserPermission::ADMIN_USER_PERMISSION,
                ],
            ], [
                'attributes' => [
                    'id' => 2,
                    'name' => 'Test User',
                    'email' => 'tester@example.com',
                    'password' => Hash::make('tester'),
                ],
                'permissions' => [],
            ], [
                'attributes' => [
                    'id' => 3,
                    'name' => 'News Edit User',
                    'email' => 'editNews@draab.at',
                    'password' => Hash::make('editNews'),
                ],
                'permissions' => [News::NEWS_EDIT_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 4,
                    'name' => 'Member Show',
                    'email' => 'memberShow@draab.at',
                    'password' => Hash::make('memberShow'),
                ],
                'permissions' => [Member::MEMBER_SHOW_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 5,
                    'name' => 'Member Edit',
                    'email' => 'memberEdit@draab.at',
                    'password' => Hash::make('memberEdit'),
                ],
                'permissions' => [Member::MEMBER_EDIT_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 6,
                    'name' => 'Attendance Show User',
                    'email' => 'attendanceShow@example.com',
                    'password' => Hash::make('attendanceShow'),
                ],
                'permissions' => [Attendance::ATTENDANCE_SHOW_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 7,
                    'name' => 'Attendance Edit User',
                    'email' => 'attendanceEdit@example.com',
                    'password' => Hash::make('attendanceEdit'),
                ],
                'permissions' => [Attendance::ATTENDANCE_EDIT_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 8,
                    'name' => 'Attendance Poll Show User',
                    'email' => 'attendancePollShow@example.com',
                    'password' => Hash::make('attendancePollShow'),
                ],
                'permissions' => [AttendancePoll::ATTENDANCE_POLL_SHOW_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 9,
                    'name' => 'Attendance Poll Edit User',
                    'email' => 'attendancePollEdit@example.com',
                    'password' => Hash::make('attendancePollEdit'),
                ],
                'permissions' => [AttendancePoll::ATTENDANCE_POLL_EDIT_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 10,
                    'name' => 'User Show User',
                    'email' => 'showUser@draab.at',
                    'password' => Hash::make('showUser'),
                ],
                'permissions' => [UserPermission::USER_MANAGEMENT_SHOW_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 11,
                    'name' => 'User Edit User',
                    'email' => 'editUser@draab.at',
                    'password' => Hash::make('editUser'),
                ],
                'permissions' => [UserPermission::USER_MANAGEMENT_EDIT_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 12,
                    'name' => 'Sponsoring Show',
                    'email' => 'sponsoringShow@draab.at',
                    'password' => Hash::make('sponsoringShow'),
                ],
                'permissions' => [Contract::SPONSORING_SHOW_PERMISSION],
            ], [
                'attributes' => [
                    'id' => 13,
                    'name' => 'Sponsoring Edit',
                    'email' => 'sponsoringEdit@draab.at',
                    'password' => Hash::make('sponsoringEdit'),
                ],
                'permissions' => [Contract::SPONSORING_EDIT_PERMISSION],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->getData() as $data) {
            $user = User::query()->create($data['attributes']);
            if ($data['permissions']) {
                foreach ($data['permissions'] as $permission) {
                    $user->userPermissions()->attach($permission);
                }
            }
        }
    }
}
