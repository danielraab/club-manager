<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Backer;
use App\Models\Sponsoring\Period;
use Livewire\Component;

class PeriodMemberAssignment extends Component
{
    public string $previousUrl;

    public Period $period;

    public string $name;
    public string $country;
    public string $city;
    public string $zip;

    public function mount(Period $period): void
    {
        $this->period = $period;
        $this->country = config('app.country_code_default');
        $this->previousUrl = url()->previous();
    }

    public function customReset(): void
    {
        $this->resetExcept('period');
        $this->country = config('app.country_code_default');
    }

    public function addNewBacker(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:2'],
            'city' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'integer'],
        ]);

        Backer::create($validated);
        $this->customReset();
    }

    public function render()
    {
        return view('livewire.sponsoring.period-member-assignment')->layout('layouts.backend');
    }
}
