<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Contracts\Database\Query\Builder;
use Livewire\Component;

class EventStatistic extends Component
{
    public ?int $selectedYear = null;
    public array $availableYears = [];

    public function mount()
    {
        $minStart = (int)substr(Event::query()->min("start"), 0, 4);
        $maxStart = (int)substr(Event::query()->max("start"), 0, 4);

        for ($i = $minStart; $i <= $maxStart; $i++) {
            $this->availableYears[] = $i;
        }
    }

    public function render()
    {
        $eventTypes = null;
        if($this->selectedYear) {
//            $events = Event::query()
//                ->select("event_type_id", DB::raw("COUNT(id) as count"))
//                ->where("events.start", ">=", "2024-01-01")
//                ->where("events.start", "<=", "2024-12-31")
//                ->groupBy("event_type_id");
//
//            dd($eventTypeCounted = EventType::query()->joinSub($events, "event_counts", function (JoinClause $join) {
//                $join->on("event_types.id", "=", "event_counts.event_type_id");
//            })->get());

            $eventTypes = EventType::query()->with(["events" => function(Builder $query) {
                $query
                    ->where("start", ">=", "$this->selectedYear-01-01 00:00:00")
                    ->where("start", "<=", "$this->selectedYear-12-31 23:59:59");
            }]);
        }

        return view('livewire.events.event-statistic', [
            "eventTypes" => $eventTypes
        ])->layout('layouts.backend');
    }
}
