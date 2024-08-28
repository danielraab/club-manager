<?php

namespace Database\Seeders;

use Database\Seeders\Better\SponsoringSeeder as BetterSponsoringSeeder;
use Database\Seeders\Minimal\UserSeeder;
use Database\Seeders\Silly\AttendanceSeeder;
use Database\Seeders\Silly\ConfigurationSeeder;
use Database\Seeders\Silly\EventSeeder;
use Database\Seeders\Silly\MemberSeeder;
use Database\Seeders\Silly\NewsSeeder;
use Database\Seeders\Silly\UserManagementSeeder;
use Illuminate\Database\Seeder;

class BetterSeeder extends Seeder
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

            BetterSponsoringSeeder::class,
        ]);
    }
}
