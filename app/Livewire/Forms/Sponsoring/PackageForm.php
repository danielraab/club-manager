<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\Package;
use Livewire\Form;

class PackageForm extends Form
{
    public ?Package $package = null;

    public bool $enabled = true;

    public string $title;

    public ?string $description;

    public bool $is_official = true;

    public ?float $price;

    protected function rules(): array
    {
        return [
            'enabled' => ['required', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_official' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric'],
        ];
    }

    public function setPackageModel(Package $package): void
    {
        $this->package = $package;

        $this->enabled = $package->enabled;
        $this->title = $package->title;
        $this->description = $package->description;
        $this->is_official = $package->is_official;
        $this->price = $package->price;
    }

    public function store(): void
    {
        $this->validate();

        $this->package = Package::create([
            ...$this->except(['package']),
        ]);

        $this->package->save();
    }

    public function update(): void
    {
        $this->validate();

        $this->package->update([
            ...$this->except(['package']),
        ]);

        $this->package->save();
    }

    public function delete(): void
    {
        $this->package?->delete();
    }
}
