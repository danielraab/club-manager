<?php

namespace Database\Seeders\SteadySeeder;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addEventTypes();
        $this->addSamples();
        $this->addTrainings();
        $this->addEvents();
        $this->addSpecialEvents();
    }

    private function addEventTypes(): void
    {
        EventType::query()->create([
            'id' => 1,
            'title' => 'Samples',
            'description' => 'Samples',
        ]);
        EventType::query()->create([
            'id' => 2,
            'title' => 'Special Samples',
            'description' => 'Some special samples',
            'parent_id' => 1,
        ]);
        EventType::query()->create([
            'id' => 3,
            'title' => 'Festival',
            'description' => 'all Festival events',
        ]);
        EventType::query()->create([
            'id' => 4,
            'title' => 'Trainings',
            'description' => 'some sport trainings',
        ]);
        EventType::query()->create([
            'id' => 5,
            'title' => 'Soccer Trainings',
            'description' => 'some soccer sport trainings',
            'parent_id' => 4,
        ]);
        EventType::query()->create([
            'id' => 6,
            'title' => 'Indoor Trainings',
            'description' => 'some indoor sport trainings',
            'parent_id' => 4,
        ]);
    }

    private function addSamples(): void
    {
        $start = now()->subMonths(6);
        $start->setTime(18, 0);
        for ($i = 0; $i < 20; $i++) {
            Event::query()->create([
                'title' => 'Musikprobe',
                'location' => 'Musikheim',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 1,
                'member_group_id' => 3,
            ]);
            $start->addWeek();
        }
        $start->addMonths(2);

        for ($i = 0; $i < 20; $i++) {
            Event::query()->create([
                'title' => 'Musikprobe',
                'location' => 'Musikheim',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 1,
                'member_group_id' => 3,
            ]);
            $start->addWeek();
        }

        $start = now()->subMonths(6);
        $start->subdays(2);
        $start->setTime(20, 0);
        for ($i = 0; $i < 5; $i++) {
            Event::query()->create([
                'title' => 'Some special sample',
                'location' => 'Musikheim',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 2,
                'member_group_id' => 3,
            ]);
            $start->addWeeks(4);
        }
        $start->addMonths(2);

        for ($i = 0; $i < 5; $i++) {
            Event::query()->create([
                'title' => 'Some special sample',
                'location' => 'Musikheim',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 2,
                'member_group_id' => 3,
            ]);
            $start->addWeeks(4);
        }
    }

    private function addTrainings(): void
    {
        $start = now()->subMonths(4);
        $start->subdays(4);
        $start->setTime(17, 0);
        for ($i = 0; $i < 20; $i++) {
            Event::query()->create([
                'title' => 'Soccer training',
                'location' => 'Sportplatz',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 5,
                'member_group_id' => 6,
            ]);
            $start->addWeeks(2);
        }

        $start = now()->subMonths(4);
        $start->subdays(5);
        $start->setTime(17, 0);
        for ($i = 0; $i < 12; $i++) {
            Event::query()->create([
                'title' => 'Indoor training',
                'location' => 'Turnhalle',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'event_type_id' => 6,
                'member_group_id' => 6,
            ]);
            $start->addWeeks(4);
        }
    }

    private function addEvents(): void
    {
        Event::query()->create([
            'title' => 'Konzert',
            'location' => 'Saal',
            'link' => 'https://www.example.com',
            'start' => $start = now()->subMonths(4)->setTime(20, 0),
            'end' => $start->addHours(2),
            'event_type_id' => 3,
        ]);

        Event::query()->create([
            'title' => 'Konzert',
            'location' => 'Saal',
            'link' => 'https://www.example.com',
            'start' => $start = now()->addMonths(3)->setTime(20, 0),
            'end' => $start->addHours(2),
            'event_type_id' => 3,
        ]);

        Event::query()->create([
            'title' => 'Ball',
            'location' => 'Saal',
            'link' => 'https://www.example.com',
            'start' => $start = now()->addMonths(6)->setTime(20, 0),
            'end' => $start->addHours(2),
            'event_type_id' => 3,
        ]);
    }

    private function addSpecialEvents(): void
    {
        $start = now()->subMonths(6);
        $start->subday();
        $start->setTime(19, 0);
        for ($i = 0; $i < 6; $i++) {
            Event::query()->create([
                'title' => 'Meeting',
                'location' => 'Sportplatz',
                'start' => $copy = $start->clone(),
                'end' => $copy->addHours(2),
                'member_group_id' => 2,
            ]);
            $start->addMonths(2);
        }

        Event::query()->create([
            'title' => 'Excursion',
            'location' => 'Far far away',
            'start' => $copy = now()->subMonths(2),
            'end' => $copy->addHours(2),
            'whole_day' => true,
            'member_group_id' => 1,
        ]);

        Event::query()->create([
            'title' => 'Excursion',
            'location' => 'Far far away',
            'start' => $copy = now()->addMonths(5),
            'end' => $copy->addHours(2),
            'whole_day' => true,
            'member_group_id' => 1,
        ]);
    }
}
