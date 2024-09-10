<?php

namespace Feature;

use Database\Seeders\BetterSeeder;
use Database\Seeders\MinimalSeeder;
use Database\Seeders\SillySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration(): void
    {
        $this->migrateFreshUsing();
        $this->assertDatabaseEmpty('attendances');
        $this->assertDatabaseEmpty('attendance_polls');
        $this->assertDatabaseEmpty('attendance_poll_event');

        $this->assertDatabaseEmpty('configurations');

        $this->assertDatabaseEmpty('events');
        $this->assertDatabaseEmpty('event_types');

        $this->assertDatabaseEmpty('members');
        $this->assertDatabaseEmpty('member_groups');
        $this->assertDatabaseEmpty('member_member_group');

        $this->assertDatabaseEmpty('news');

        $this->assertDatabaseEmpty('personal_access_tokens');
        $this->assertDatabaseEmpty('push_subscriptions');

        $this->assertDatabaseEmpty('sponsor_ad_options');
        $this->assertDatabaseEmpty('sponsor_ad_placements');
        $this->assertDatabaseEmpty('sponsor_backers');
        $this->assertDatabaseEmpty('sponsor_contracts');
        $this->assertDatabaseEmpty('sponsor_packages');
        $this->assertDatabaseEmpty('sponsor_package_sponsor_ad_option');
        $this->assertDatabaseEmpty('sponsor_periods');
        $this->assertDatabaseEmpty('sponsor_period_sponsor_package');

        $this->assertDatabaseEmpty('uploaded_files');

        $this->assertDatabaseEmpty('users');
        $this->assertDatabaseCount('user_permissions', 15);
        $this->assertDatabaseEmpty('user_user_permission');
    }

    public function test_minimal_seeder(): void
    {
        $this->seed(MinimalSeeder::class);
    }

    //    public function test_silly_seeder(): void
    //    {
    //        $this->seed(SillySeeder::class);
    //    }

    //    public function test_better_seeder(): void
    //    {
    //        $this->seed(BetterSeeder::class);
    //    }
}
