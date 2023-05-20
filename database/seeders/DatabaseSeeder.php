<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $admin;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $userShow;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $userEdit;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $newsEdit;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $user;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->addUsers();
        $this->addNews();
    }

    private function addUsers(): void
    {
        $this->admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@draab.at',
            'password' => Hash::make('admin'),
        ]);
        $this->admin->userPermissions()->attach(UserPermission::ADMIN_USER_PERMISSION);

        /** @var User $userShow */
        $this->userShow = \App\Models\User::factory()->create([
            'name' => 'User Show User',
            'email' => 'editShow@draab.at',
            'password' => Hash::make('editShow'),
        ]);
        $this->userShow->userPermissions()->attach(UserPermission::USER_MANAGEMENT_SHOW_PERMISSION);

        $this->userEdit = \App\Models\User::factory()->create([
            'name' => 'User Edit User',
            'email' => 'editUser@draab.at',
            'password' => Hash::make('editUser'),
        ]);
        $this->userEdit->userPermissions()->attach(UserPermission::USER_MANAGEMENT_EDIT_PERMISSION);

        $this->newsEdit = \App\Models\User::factory()->create([
            'name' => 'News Edit User',
            'email' => 'editNews@draab.at',
            'password' => Hash::make('editNews'),
        ]);
        $this->newsEdit->userPermissions()->attach(News::NEWS_EDIT_PERMISSION);

        $this->user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'tester@draab.at',
            'password' => Hash::make('tester'),
        ]);

        $this->command->info("Fake users added.");
    }

    private function addNews(): void {
        News::factory(1)->create([
            'title' => null,
            'logged_in_only' => true,
            'display_until' => now()->addDays(6),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(1)->create([
            'content' => null,
            'logged_in_only' => true,
            'display_until' => now()->addDays(5),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(1)->create([
            'logged_in_only' => true,
            'display_until' => now()->addWeek(),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(2)->create([
            'display_until' => now()->addDays(3),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(2)->create([
            'title' => "enabled false, logged_in_only, now",
            'enabled' => false,
            'logged_in_only' => false,
            'display_until' => now(),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(5)->create([
            'logged_in_only' => true,
            'display_until' => now()->subDays(3),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id
        ]);
        News::factory(4)->create([
            'logged_in_only' => false,
            'display_until' => now()->subWeek(),
            'creator_id' => $this->newsEdit->id
        ]);
        News::factory(1)->create([
            'logged_in_only' => false,
            'display_until' => now()->subWeek(2)
        ]);

        $this->command->info("Fake news added.");
    }
}
