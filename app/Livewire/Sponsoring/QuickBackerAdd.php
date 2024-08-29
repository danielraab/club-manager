<?php

namespace App\Livewire\Sponsoring;

use App\Models\Sponsoring\Backer;
use Livewire\Component;

class QuickBackerAdd extends Component
{
    public string $name;

    public string $country;

    public string $city;

    public string $zip;

    public function mount(): void
    {
        $this->country = config('app.country_code_default');
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

        Backer::query()->create($validated);
        $this->customReset();
        $this->dispatch('member-contract-has-changed');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.sponsoring.quick-backer-add');
    }
}
