<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\Period;
use Carbon\Carbon;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PeriodForm extends Form
{
    public ?Period $period = null;

    #[Rule('required|max:255')]
    public string $title;

    public ?string $description;

    #[Rule('required|date')]
    public string $start;

    #[Rule('required|date|after_or_equal:periodForm.start')]
    public string $end;

    public function setPeriodModel(Period $period): void
    {
        $this->period = $period;

        $this->title = $period->title;
        $this->description = $period->description;
        $this->start = $period->start->formatDateInput();
        $this->end = $period->end->formatDateInput();
    }

    public function store(): void
    {
        $this->validate();

        $this->period = Period::create([
            ...$this->except(['period', 'start', 'end']),
            'start' => Carbon::parseFromDatetimeLocalInput($this->start),
            'end' => Carbon::parseFromDatetimeLocalInput($this->end),
        ]);

        $this->period->save();
    }

    public function update(): void
    {
        $this->validate();

        $this->period->update([
            ...$this->except(['period', 'start', 'end']),
            'start' => Carbon::parseFromDatetimeLocalInput($this->start),
            'end' => Carbon::parseFromDatetimeLocalInput($this->end),
        ]);

        $this->period->save();
    }

    public function delete(): void
    {
        $this->period?->delete();
    }
}
