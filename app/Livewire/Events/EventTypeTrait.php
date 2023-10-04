<?php

namespace App\Livewire\Events;

use App\Models\EventType;

trait EventTypeTrait
{
    public EventType $eventType;

    public string $previousUrl;

    public ?string $parent = null;

    protected array $rules = [
        'eventType.title' => ['required', 'string', 'max:255'],
        'eventType.description' => ['nullable', 'string'],
        'parent' => ['nullable', 'int', 'exists:event_types,id'],
    ];

    public function propToModel()
    {

        $parentId = intval($this->parent);
        if ($parentId > 0 && $parentId !== $this->eventType->id) {
            $this->eventType->parent_id = $parentId;
        } else {
            $this->eventType->parent_id = null;
        }
    }

    protected function saveEventTypeWithMessage(string $message): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Foundation\Application
    {
        $this->validate();
        $this->propToModel();
        $this->eventType->save();

        session()->put('message', $message);

        return redirect($this->previousUrl);
    }
}
