<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Period;
use Livewire\Component;

class PeriodBackerOverview extends Component
{
    public Period $period;
    public string $previousUrl;

    public function mount(Period $period): void
    {
        $this->period = $period;
        $this->previousUrl = url()->previous();
    }

    public function render()
    {
        return view('livewire.sponsoring.period-backer-overview')->layout('layouts.backend');
    }
}
