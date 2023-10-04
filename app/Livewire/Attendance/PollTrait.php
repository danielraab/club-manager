<?php

namespace App\Livewire\Attendance;

use App\Models\AttendancePoll;
use Carbon\Carbon;

trait PollTrait
{
    public AttendancePoll $poll;

    public string $closing_at;
    public bool $showOnlyFutureEvents = true;

    public ?string $memberGroup = null;

    public string $previousUrl;

    /** @var int[] */
    public array $selectedEvents = [];

    protected array $rules = [
        'poll.title' => ['required', 'string', 'max:255'],
        'poll.description' => ['nullable', 'string'],
        'poll.allow_anonymous_vote' => ['nullable', 'boolean'],
        'memberGroup' => ['nullable', 'int', 'exists:member_groups,id'],
        'selectedEvents' => ['nullable', 'array'],
        'closing_at' => ['required', 'date'],
    ];

    protected function propToModel(): void
    {
        $this->poll->closing_at = Carbon::parseFromDatetimeLocalInput($this->closing_at);

        $memberGroupId = intval($this->memberGroup);
        if ($memberGroupId > 0) {
            $this->poll->member_group_id = $memberGroupId;
        } else {
            $this->poll->member_group_id = null;
        }
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
