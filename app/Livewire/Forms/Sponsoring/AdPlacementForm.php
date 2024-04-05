<?php

namespace App\Livewire\Forms\Sponsoring;

use App\Models\Sponsoring\AdPlacement;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class AdPlacementForm extends Form
{
    public ?AdPlacement $adPlacement = null;

    public bool $done = false;

    public ?string $comment;

    protected function rules(): array
    {
        return [
            'done' => ['required', 'boolean'],
            'comment' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function setAdPlacementModel(AdPlacement $adPlacement): void
    {
        $this->adPlacement = $adPlacement;

        $this->done = $adPlacement->done;
        $this->comment = $adPlacement->comment;
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();

        $this->adPlacement->update([
            ...$this->except(['adPlacement']),
        ]);
    }
}
