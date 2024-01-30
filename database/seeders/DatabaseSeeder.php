<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserManagementSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            MemberSeeder::class,
            AttendanceSeeder::class,
            ConfigurationSeeder::class,
        ]);
    }
}
