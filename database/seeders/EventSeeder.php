<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EventSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $eventEdit;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $firstEventType,$secondEventType,$secondSecondEventType,$thirdEventType,$thirdThirdEventType;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->addUsers();
        $this->addEventTypes();
        $this->addEvents();
    }

    private function addUsers() {

        $this->eventEdit = \App\Models\User::factory()->create([
            'name' => 'Event Edit User',
            'email' => 'eventEdit@draab.at',
            'password' => Hash::make('eventEdit'),
        ]);
        $this->eventEdit->userPermissions()->attach(Event::EVENT_EDIT_PERMISSION);
    }

    public function addEventTypes()
    {
        $this->firstEventType = EventType::factory()->create();
        $this->secondEventType = EventType::factory()->create();
        $this->secondEventType->parent()->associate($this->firstEventType);
        $this->secondEventType->save();
        $this->secondSecondEventType = EventType::factory()->create();
        $this->secondSecondEventType->parent()->associate($this->firstEventType);
        $this->secondSecondEventType->save();
        $this->thirdEventType = EventType::factory()->create();
        $this->thirdEventType->parent()->associate($this->secondEventType);
        $this->thirdEventType->save();
        $this->thirdThirdEventType = EventType::factory()->create();
        $this->thirdThirdEventType->parent()->associate($this->secondSecondEventType);
        $this->thirdThirdEventType->save();
    }

    private function addEvents()
    {
        Event::factory(10)->create([
            "enabled" => false,
            "event_type_id" => $this->firstEventType->id,
            "creator_id" => $this->eventEdit->id,
            "last_updater_id" => $this->eventEdit->id
        ]);
        Event::factory(10)->create([
            'logged_in_only' => true,
            "event_type_id" => $this->firstEventType->id,
            "creator_id" => $this->eventEdit->id,
            "last_updater_id" => $this->eventEdit->id
        ]);

        $startFirst = now()->addWeek();
        Event::factory()->create([
            "start" => $startFirst,
            "end" => $startFirst->clone()->addHours(2),
            "event_type_id" => $this->firstEventType->id,
            "creator_id" => $this->eventEdit->id,
            "last_updater_id" => $this->eventEdit->id
        ]);

        $startSecond = now()->addDays(3);
        Event::factory()->create([
            "start" => $startSecond,
            "end" => $startSecond->clone()->addDays(2),
            "whole_day" => true,
            "event_type_id" => $this->firstEventType->id,
            "creator_id" => $this->eventEdit->id,
            "last_updater_id" => $this->eventEdit->id
        ]);
    }
}
