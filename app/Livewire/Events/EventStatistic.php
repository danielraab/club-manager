<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class EventStatistic extends Component
{
    public const SESSION_KEY_SELECTED_YEAR = "eventStatSelectedYear";

    public ?int $selectedYear = null;
    public array $availableYears = [];

    public function updatedSelectedYear($value)
    {
        session([self::SESSION_KEY_SELECTED_YEAR => $value]);
    }

    public function mount()
    {
        $minStart = (int)substr(Event::query()->min("start"), 0, 4);
        $maxStart = (int)substr(Event::query()->max("start"), 0, 4);

        for ($i = $maxStart; $i >= $minStart; $i--) {
            $this->availableYears[] = $i;
        }

        if (session()->has(self::SESSION_KEY_SELECTED_YEAR)) {
            $this->selectedYear = session(self::SESSION_KEY_SELECTED_YEAR);
        } else if (count($this->availableYears) > 0) {
            $this->selectedYear = $this->availableYears[0];
        }
    }

    public function render()
    {
        return view('livewire.events.event-statistic')->layout('layouts.backend');
    }
}
