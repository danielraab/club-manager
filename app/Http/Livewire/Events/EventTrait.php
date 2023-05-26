<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Carbon\Carbon;

trait EventTrait
{

    protected string $datetimeLocalFormat = "Y-m-d\TH:i";

    public Event $event;
    public string $start;
    public string $end;
    public ?string $type = null;

    protected array $rules = [
        "event.title" => ["required", "string", "max:255"],
        "event.description" => ["nullable", "string"],
        "event.location" => ["nullable", "string", "max:255"],
        "event.dress_code" => ["nullable", "string", "max:255"],
        "event.link" => ["nullable", "string"],
        "event.enabled" => ["nullable", "boolean"],
        "event.whole_day" => ["nullable", "boolean"],
        "event.logged_in_only" => ["nullable", "boolean"],
        "start" => ["required", "date"],
        "end" => ["required", "date", "after_or_equal:start"],
        "type" => ["nullable", "int", "exists:event_types,id"]
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
        $this->event->start = Carbon::parse($this->start)->shiftTimezone(config("app.displayed_timezone"))->setTimezone("UTC");
        $this->event->end = Carbon::parse($this->end)->shiftTimezone(config("app.displayed_timezone"))->setTimezone("UTC");

        $eventTypeId = intval($this->type);
        if($eventTypeId > 0) {
            $this->event->event_type_id = $eventTypeId;
        } else {
            $this->event->event_type_id = null;
        }
    }
}
