<?php

namespace App\Http\Livewire\Events;

use App\Models\Event;
use Illuminate\Support\Facades\Date;

trait EventTrait
{

    protected string $datetimeLocalFormat = "Y-m-d\TH:i";

    public Event $event;
    public string $start;
    public string $end;

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
        "end" => ["required", "date", "after:start"]
    ];


    public function updatingStart($updatedValue): void
    {
        if ($updatedValue > $this->end) {
            $oldStart = Date::createFromFormat($this->datetimeLocalFormat, $this->start);
            $oldEnd = Date::createFromFormat($this->datetimeLocalFormat, $this->end);
            $diff = $oldStart->diff($oldEnd);
            $newStart = Date::createFromFormat($this->datetimeLocalFormat, $updatedValue);
            $this->end = $newStart->add($diff)->format($this->datetimeLocalFormat);
        }
    }

    public function propToModel() {
        $this->event->start = $this->start;
        $this->event->end = $this->end;
    }
}
