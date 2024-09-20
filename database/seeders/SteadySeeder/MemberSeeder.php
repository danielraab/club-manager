<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\MemberGroup;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function getData(): array
    {
        return [
            [
                'attributes' => [
                    'id' => 1,
                    'title' => 'All members',
                    'description' => 'A first small description',
                    'parent_id' => null,
                ],
            ], [
                'attributes' => [
                    'id' => 3,
                    'title' => 'Musicians',
                    'description' => 'A small description',
                    'parent_id' => 1,
                ],
            ], [
                'attributes' => [
                    'id' => 4,
                    'title' => 'Wind instruments',
                    'description' => null,
                    'parent_id' => 3,
                ],
            ], [
                'attributes' => [
                    'id' => 5,
                    'title' => 'Drummers',
                    'description' => null,
                    'parent_id' => 3,
                ],
            ], [
                'attributes' => [
                    'id' => 6,
                    'title' => 'Sporties',
                    'description' => null,
                    'parent_id' => 1,
                ],
            ], [
                'attributes' => [
                    'id' => 2,
                    'title' => 'Vorstand',
                    'description' => 'The second small description',
                    'parent_id' => null,
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->getData() as $data) {
            $user = MemberGroup::query()->create($data['attributes']);
        }
    }
}
