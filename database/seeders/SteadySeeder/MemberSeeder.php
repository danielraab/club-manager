<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\Member;
use App\Models\MemberGroup;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    private const FIRSTNAMES = [
        'Lucas', 'Alexander', 'Oliver', 'Mohammed', 'Noah', 'Elias', 'Matteo', 'Gabriel', 'Daniel', 'Liam',
        'Sofia', 'Hanna', 'Maria', 'Isabella', 'Amelia', 'Jasmina', 'Emma', 'Emilia', 'Sara', 'Elisabeth',
    ];

    private const LASTNAMES = [
        'Gruber', 'Huber', 'Bauer', 'Wagner', 'Müller', 'Pichler', 'Steiner', 'Moser', 'Mayer', 'Hofer',
        'Leitner', 'Berger', 'Fuchs', 'Eder', 'Fischer', 'Schmid', 'Winkler', 'Weber', 'Schwarz', 'Maier',
    ];

    private const STREETNAMES = [
        'Altgasse', 'Favoritenstraße', 'Spittelberg', 'Herrengasse', 'Rotenturmstraße', 'Kärntner Strasse',
    ];

    private const CITIES = [
        'Wien', 'Berlin', 'Linz', 'Graz', 'Innsbruch', 'München', 'Köln',
    ];

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

        $this->addMemberGroups();
        $this->addMembers();
    }

    private function addMemberGroups(): void
    {
        foreach ($this->getData() as $data) {
            $user = MemberGroup::query()->create($data['attributes']);
        }
    }

    private function addMembers()
    {
        $birthday = now()->subYears(70);
        $entranceDate = now()->subYears(50);
        for ($i = 0; $i < count(self::LASTNAMES) && $i < count(self::FIRSTNAMES); $i++) {
            $attributes = [
                'firstname' => self::FIRSTNAMES[$i],
                'lastname' => self::LASTNAMES[$i],
                'birthday' => $birthday,
                'email' => self::LASTNAMES[$i].'@example.com',
                'street' => self::STREETNAMES[$i % count(self::STREETNAMES)].' '.$i.$i,
                'zip' => $i.$i.$i,
                'city' => self::CITIES[$i % count(self::CITIES)],
                'entrance_date' => $entranceDate->addDays(700),
            ];
            if ($i === 0) {
                $attributes['title_pre'] = 'Dr.';
            }
            if ($i === 1) {
                $attributes['title_post'] = 'MA';
            }
            if ($i === 2) {
                $attributes['paused'] = true;
            }
            if ($i === 3) {
                $attributes['birthday'] = null;
            }
            if ($i === 4) {
                $attributes['phone'] = '0123456789';
            }
            if ($i === 5) {
                $attributes['email'] = 'admin@example.com';
            }
            if ($i === 6) {
                $attributes['street'] = null;
                $attributes['zip'] = null;
                $attributes['city'] = null;
            }
            if ($i === 7) {
                $attributes['info'] = 'Some very special information';
            }
            if ($i === 8 || $i === 9) {
                $attributes['leaving_date'] = $entranceDate->clone()->days(500);
            }

            $member = Member::query()->create($attributes);

            for ($j = 0; $j <= $j % 3; $j++) {
                $member->memberGroups()->attach((($j + $i) % 6) + 1);
            }

            $birthday->addYears(3)->addDays(10);
        }
    }
}
