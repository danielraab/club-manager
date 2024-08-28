<?php

namespace Database\Seeders;

use Database\Seeders\Minimal\SponsoringSeeder;
use Database\Seeders\Minimal\UserSeeder;
use Illuminate\Database\Seeder;

class MinimalSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SponsoringSeeder::class,
        ]);
    }
}
