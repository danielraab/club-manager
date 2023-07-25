<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendancePoll;
use Carbon\Carbon;

trait PollTrait
{
    public AttendancePoll $poll;

    public string $closing_at;
    public bool $showOnlyFutureEvents = true;

    public string $previousUrl;

    /** @var int[] */
    public array $selectedEvents = [];

    protected array $rules = [
        'poll.title' => ['required', 'string', 'max:255'],
        'poll.description' => ['nullable', 'string'],
        'poll.enabled' => ['nullable', 'boolean'],
        'poll.allow_anonymous_vote' => ['nullable', 'boolean'],
        'selectedEvents' => ['nullable', 'array'],
        'closing_at' => ['required', 'date'],
    ];

    protected function propToModel(): void
    {
        $this->poll->closing_at = Carbon::parseFromDatetimeLocalInput($this->closing_at);
    }

    public function addEventsToSelection($additionalEventIdList): void
    {
        $this->selectedEvents = array_unique(array_merge($this->selectedEvents, $additionalEventIdList));
    }

    public function removeEventFromSelection($eventId): void
    {
        $this->selectedEvents = array_filter($this->selectedEvents, fn ($loopEventId) => $loopEventId != $eventId);
    }
}
