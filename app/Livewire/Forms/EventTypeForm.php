<?php

namespace App\Livewire\Forms;

use App\Models\EventType;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventTypeForm extends Form
{
    public ?EventType $eventType = null;

    #[Validate('max:255')]
    public string $title;

    public ?string $description = null;

    #[Validate('nullable|exists:event_types,id')]
    public ?int $parent = null;

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->validate();

        $this->eventType = EventType::create([
            'parent_id' => $this->getParentId(),
            ...$this->except('eventType', 'parent'),
        ]);
    }

    private function getParentId(): ?int
    {
        $parent_id = intval($this->parent);
        if ($parent_id > 0 && $parent_id !== $this->eventType?->id) {
            return $parent_id;
        }

        return null;
    }

    public function setEventType(EventType $eventType): void
    {
        $this->eventType = $eventType;
        $this->title = $eventType->title;
        $this->description = $eventType->description;
        $this->parent = $eventType->parent()->first()?->id;
    }

    public function delete(): void
    {
        $this->eventType?->delete();
    }

    public function update(): void
    {
        $this->validate();

        $this->eventType->update([
            'parent_id' => $this->getParentId(),
            ...$this->except('eventType', 'parent'),
        ]);
    }
}
