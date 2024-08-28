<?php

namespace Database\Seeders\Minimal;

use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public const ADMIN_MAIL = 'admin@example.com';

    public const ADMIN_PASSWORD = 'admin';

    public const TESTER_MAIL = 'tester@example.com';

    public const TESTER_PASSWORD = 'tester';

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $admin;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $noPermissionUser;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => self::ADMIN_MAIL,
            'password' => Hash::make(self::ADMIN_PASSWORD),
        ]);
        $this->admin->userPermissions()->attach(UserPermission::ADMIN_USER_PERMISSION);

        $this->noPermissionUser = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => self::TESTER_MAIL,
            'password' => Hash::make(self::TESTER_PASSWORD),
        ]);
    }
}
