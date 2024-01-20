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

        for ($i = $maxStart; $i >= $minStart; $i--) {
            $this->availableYears[] = $i;
        }

        if(count($this->availableYears) > 0) {
            $this->selectedYear = $this->availableYears[0];
        }
    }

    public function render()
    {
        return view('livewire.events.event-statistic')->layout('layouts.backend');
    }
}
