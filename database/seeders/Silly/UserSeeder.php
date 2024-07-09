<?php

namespace Database\Seeders\Silly;

use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
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
            'email' => 'admin@draab.at',
            'password' => Hash::make('admin'),
        ]);
        $this->admin->userPermissions()->attach(UserPermission::ADMIN_USER_PERMISSION);

        $this->noPermissionUser = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'tester@draab.at',
            'password' => Hash::make('tester'),
        ]);
    }
}
