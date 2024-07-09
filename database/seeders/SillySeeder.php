<?php

namespace Database\Seeders;

use Database\Seeders\Silly\AttendanceSeeder;
use Database\Seeders\Silly\ConfigurationSeeder;
use Database\Seeders\Silly\EventSeeder;
use Database\Seeders\Silly\MemberSeeder;
use Database\Seeders\Silly\NewsSeeder;
use Database\Seeders\Silly\SponsoringSeeder;
use Database\Seeders\Silly\UserManagementSeeder;
use Database\Seeders\Silly\UserSeeder;
use Illuminate\Database\Seeder;

class SillySeeder extends Seeder
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
            SponsoringSeeder::class,
        ]);
    }
}
