<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewsSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $newsEdit;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addUsers();
        $this->addNews();
    }

    private function addUsers()
    {

        $this->newsEdit = \App\Models\User::factory()->create([
            'name' => 'News Edit User',
            'email' => 'editNews@draab.at',
            'password' => Hash::make('editNews'),
        ]);
        $this->newsEdit->userPermissions()->attach(News::NEWS_EDIT_PERMISSION);
    }

    private function addNews(): void
    {
        News::factory()->create([
            'title' => null,
            'logged_in_only' => true,
            'display_until' => now()->addDays(6),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory()->create([
            'content' => null,
            'logged_in_only' => true,
            'display_until' => now()->addDays(5),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory()->create([
            'logged_in_only' => true,
            'display_until' => now()->addWeek(),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory(2)->create([
            'display_until' => now()->addDays(3),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory(2)->create([
            'title' => 'enabled false, logged_in_only, now',
            'enabled' => false,
            'logged_in_only' => false,
            'display_until' => now(),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory(5)->create([
            'logged_in_only' => true,
            'display_until' => now()->subDays(3),
            'creator_id' => $this->newsEdit->id,
            'last_updater_id' => $this->newsEdit->id,
        ]);
        News::factory(4)->create([
            'logged_in_only' => false,
            'display_until' => now()->subWeek(),
            'creator_id' => $this->newsEdit->id,
        ]);
        News::factory(1)->create([
            'logged_in_only' => false,
            'display_until' => now()->subWeek(2),
        ]);

    }
}
