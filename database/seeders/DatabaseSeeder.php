<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->singleAdminUser();
    }

    private function singleAdminUser(): void
    {
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@draab.at',
            'password' => Hash::make("admin")
        ]);
        $admin->userPermissions()->attach(UserPermission::ADMIN_USER);

        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'tester@draab.at',
            'password' => Hash::make("test")
        ]);
    }
}
