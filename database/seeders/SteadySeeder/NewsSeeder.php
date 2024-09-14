<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addNews();
    }

    private function addNews(): void
    {
        News::query()->create([
            'title' => null,
            'content' => 'Here comes short an important news.',
            'logged_in_only' => false,
            'display_until' => now()->addDays(6),
            'creator_id' => 1,
            'last_updater_id' => 1,
        ]);
        News::query()->create([
            'title' => null,
            'content' => 'Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news.',
            'logged_in_only' => false,
            'display_until' => now()->addDays(5),
            'creator_id' => 3,
            'last_updater_id' => 3,
        ]);
        News::query()->create([
            'title' => 'A news with only a title',
            'content' => null,
            'logged_in_only' => false,
            'display_until' => now()->addDays(10),
            'creator_id' => 3,
            'last_updater_id' => 1,
        ]);
        News::query()->create([
            'title' => 'A news which is already in the past',
            'content' => null,
            'logged_in_only' => false,
            'display_until' => now()->subDays(6),
            'creator_id' => 3,
            'last_updater_id' => 1,
        ]);
        News::query()->create([
            'title' => 'A news which is already in the past and logged in users only',
            'content' => null,
            'logged_in_only' => false,
            'display_until' => now()->subDays(6),
            'creator_id' => 3,
            'last_updater_id' => 1,
        ]);
        News::query()->create([
            'title' => 'A news with title and content.',
            'content' => 'Here comes short and important news.',
            'logged_in_only' => false,
            'display_until' => now()->addDays(10),
            'creator_id' => 1,
            'last_updater_id' => 3,
        ]);
        News::query()->create([
            'title' => 'Only for logged in users',
            'content' => 'Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news. Here comes a very long an important news.',
            'logged_in_only' => true,
            'display_until' => now()->addDays(1),
            'creator_id' => 3,
            'last_updater_id' => 3,
        ]);
    }
}
