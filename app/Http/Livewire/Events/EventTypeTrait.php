<?php

namespace App\Http\Livewire\Events;

use App\Models\EventType;

trait EventTypeTrait
{

    public EventType $eventType;
    public ?string $parent = null;

    protected array $rules = [
        "eventType.title" => ["required", "string", "max:255"],
        "eventType.description" => ["nullable", "string"],
        "parent" => ["nullable", "int", "exists:event_types,id"]
    ];


    public function updatingStart($updatedValue): void
    {
        if ($updatedValue > $this->end) {
            $this->end = $updatedValue;
        }
    }

    public function updatingEnd($updatedValue): void
    {
        if ($updatedValue < $this->start) {
            $this->start = $updatedValue;
        }
    }

    public function propToModel() {

        $parentId = intval($this->parent);
        if($parentId > 0 && $parentId !== $this->eventType->id) {
            $this->eventType->parent_id = $parentId;
        }
    }
}
