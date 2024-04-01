<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\Backer;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Form;

class BackerForm extends Form
{
    public ?Backer $backer = null;

    public bool $enabled = true;

    public string $name;

    public ?string $contact_person;

    public ?string $phone;

    public ?string $email;

    public ?string $website;

    public ?string $street;

    public int $zip;

    public string $city;

    public string $country;

    public ?string $info;

    public ?string $closed_at = null;

    public function __construct(Component $component, $propertyName)
    {
        parent::__construct($component, $propertyName);
        $this->country = "AT"; //todo load from config
    }

    protected function rules(): array
    {
        return [
            'enabled' => ['required', 'boolean'],
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'zip' => ['required', 'integer'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:2'],
            'info' => ['nullable', 'string'],
            'closed_at' => ['nullable', 'date'],
        ];
    }

    public function setBackerModel(Backer $backer): void
    {
        $this->backer = $backer;

        $this->enabled = $backer->enabled;
        $this->name = $backer->name;
        $this->contact_person = $backer->contact_person;
        $this->phone = $backer->phone;
        $this->email = $backer->email;
        $this->website = $backer->website;
        $this->street = $backer->street;
        $this->zip = $backer->zip;
        $this->city = $backer->city;
        $this->country = $backer->country;
        $this->info = $backer->info;

        $this->closed_at = $backer->closed_at?->format('Y-m-d');
    }

    public function store(): void
    {
        $this->validate();

        $this->backer = Backer::create([
            ...$this->except(['backer', 'closed_at']),
            'closed_at' => $this->closed_at ? new Carbon($this->closed_at) : null,
        ]);

        $this->backer->save();
    }

    public function update(): void
    {
        $this->validate();

        $this->backer->update([
            ...$this->except(['backer', 'closed_at']),
            'closed_at' => $this->closed_at ? new Carbon($this->closed_at) : null,
        ]);

        $this->backer->save();
    }

    public function delete(): void
    {
        $this->backer?->delete();
    }
}
