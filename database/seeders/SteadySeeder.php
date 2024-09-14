<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SteadySeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SteadySeeder\UserSeeder::class,
            SteadySeeder\NewsSeeder::class,
            SteadySeeder\MemberGroupSeeder::class,
        ]);
    }
}
