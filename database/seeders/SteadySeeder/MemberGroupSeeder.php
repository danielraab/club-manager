<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\MemberGroup;
use Illuminate\Database\Seeder;

class MemberGroupSeeder extends Seeder
{
    public function getData(): array
    {
        return [
            [
                'attributes' => [
                    'id' => 1,
                    'title' => 'First Main Group',
                    'description' => 'A first small description',
                    'parent_id' => null,
                ],
            ], [
                'attributes' => [
                    'id' => 3,
                    'title' => 'A second level Group',
                    'description' => 'A small description',
                    'parent_id' => 1,
                ],
            ], [
                'attributes' => [
                    'id' => 4,
                    'title' => 'A third level Group',
                    'description' => null,
                    'parent_id' => 3,
                ],
            ], [
                'attributes' => [
                    'id' => 5,
                    'title' => 'One more third level Group',
                    'description' => null,
                    'parent_id' => 3,
                ],
            ], [
                'attributes' => [
                    'id' => 6,
                    'title' => 'One more second level Group',
                    'description' => null,
                    'parent_id' => 1,
                ],
            ], [
                'attributes' => [
                    'id' => 2,
                    'title' => 'Second Main Group',
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
