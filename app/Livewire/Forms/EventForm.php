<?php

namespace App\Livewire\Forms;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventForm extends Form
{
    public ?Event $event;

    #[Validate('required|max:255')]
    public string $title;

    public ?string $description;

    #[Validate('max:255')]
    public ?string $location;

    #[Validate('max:255')]
    public ?string $dress_code;

    public ?string $link;

    public ?bool $enabled;

    public ?bool $whole_day;

    public ?bool $logged_in_only;

    #[Validate('required|date')]
    public string $start;

    #[Validate('required|date|after_or_equal:start')]
    public string $end;

    #[Validate('int|exists:event_types,id')]
    public ?string $type = null;

    public function updatingStart($updatedValue): void
    {
        /** @var Carbon $oldStart */
        $oldStart = Carbon::parseFromDatetimeLocalInput($this->start);
        $oldEnd = Carbon::parseFromDatetimeLocalInput($this->end);
        $diff = $oldStart->diff($oldEnd);
        $this->end = Carbon::parseFromDatetimeLocalInput($updatedValue)->add($diff)->formatDatetimeLocalInput();
    }

    public function updatingEnd($updatedValue): void
    {
        if ($updatedValue < $this->start) {
            $this->start = $updatedValue;
        }
    }

    public function store(): void
    {
        $this->validate();

        $this->event = Event::create([
            ...$this->except(['event', 'start', 'end', 'type']),
            'start' => Carbon::parseFromDatetimeLocalInput($this->start),
            'end' => Carbon::parseFromDatetimeLocalInput($this->end),
            'event_type_id' => $this->getEventTypeId(),
        ]);

        $this->event->creator()->associate(Auth::user());
        $this->event->lastUpdater()->associate(Auth::user());

        $this->event->save();
    }

    public function update(): void
    {
        $this->validate();

        $this->event->update([
            ...$this->except(['event', 'start', 'end', 'type']),
            'start' => Carbon::parseFromDatetimeLocalInput($this->start),
            'end' => Carbon::parseFromDatetimeLocalInput($this->end),
            'event_type_id' => $this->getEventTypeId(),
        ]);
        $this->event->lastUpdater()->associate(Auth::user());

        $this->event->save();
    }

    private function getEventTypeId(): ?int
    {
        $eventTypeId = intval($this->type);
        if ($eventTypeId > 0) {
            return $eventTypeId;
        }

        return null;
    }

    public function setEventModel(Event $event): void
    {
        $this->event = $event;

        $this->title = $event->title;
        $this->description = $event->description;
        $this->location = $event->location;
        $this->dress_code = $event->dress_code;
        $this->link = $event->link;
        $this->enabled = $event->enabled;
        $this->whole_day = $event->whole_day;
        $this->logged_in_only = $event->logged_in_only;

        $this->start = $event->start->formatDatetimeLocalInput();
        $this->end = $event->end->formatDatetimeLocalInput();
        $this->type = $event->event_type_id;
    }

    public function delete(): void
    {
        $this->event?->delete();
    }
}
