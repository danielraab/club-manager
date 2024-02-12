<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\AdOption;
use Livewire\Form;

class AdOptionForm extends Form
{
    public ?AdOption $adOption = null;

    public bool $enabled = true;

    public string $title;

    public ?string $description;

    public float $price;

    protected function rules(): array
    {
        return [
            'enabled' => ['required', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric'],
        ];
    }

    public function setAdOptionModel(AdOption $adOption): void
    {
        $this->adOption = $adOption;

        $this->enabled = $adOption->enabled;
        $this->title = $adOption->title;
        $this->description = $adOption->description;
        $this->price = $adOption->price;
    }

    public function store(): void
    {
        $this->validate();

        $this->adOption = AdOption::create([
            ...$this->except(['adOption'])
        ]);

        $this->adOption->save();
    }

    public function update(): void
    {
        $this->validate();

        $this->adOption->update([
            ...$this->except(['adOption']),
        ]);

        $this->adOption->save();
    }

    public function delete(): void
    {
        $this->adOption?->delete();
    }
}
