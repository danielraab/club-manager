<?php

namespace App\Livewire\Forms;

use App\Models\AttendancePoll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class PollForm extends Form
{
    public ?AttendancePoll $poll = null;

    public string $title;

    public ?string $description;

    public ?bool $allow_anonymous_vote;
    public ?bool $show_public_stats;

    public ?string $memberGroup = null;

    /** @var int[] */
    public array $selectedEvents = [];

    public string $closing_at;

    public bool $showOnlyFutureEvents = true;

    protected array $rules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'allow_anonymous_vote' => ['nullable', 'boolean'],
        'show_public_stats' => ['nullable', 'boolean'],
        'memberGroup' => ['nullable', 'int', 'exists:member_groups,id'],
        'selectedEvents' => ['nullable', 'array'],
        'closing_at' => ['required', 'date'],
    ];

    public function setModel(AttendancePoll $attendancePoll): void
    {
        $this->poll = $attendancePoll;
        $this->title = $this->poll->title;
        $this->description = $this->poll->description;
        $this->allow_anonymous_vote = $this->poll->allow_anonymous_vote;
        $this->show_public_stats = $this->poll->show_public_stats;
        $this->closing_at = $this->poll->closing_at->formatDatetimeLocalInput();
        $this->memberGroup = $this->poll->memberGroup()->first('id')?->id;
        $this->selectedEvents = $this->poll->events()->pluck('id')->toArray();
    }

    public function store(): void
    {

        $this->validate();

        $this->poll = AttendancePoll::create([
            ...$this->except(['poll', 'memberGroup', 'selectedEvents', 'closing_at']),
            'member_group_id' => $this->getMemberGroupId(),
            'closing_at' => Carbon::parseFromDatetimeLocalInput($this->closing_at),
        ]);

        $this->poll->creator()->associate(Auth::user());
        $this->poll->lastUpdater()->associate(Auth::user());
        $this->poll->save();
        $this->poll->events()->sync($this->selectedEvents);
    }

    public function update(): void
    {
        $this->validate();

        $this->poll->update([
            ...$this->except(['poll', 'memberGroup', 'selectedEvents', 'closing_at']),
            'member_group_id' => $this->getMemberGroupId(),
            'closing_at' => Carbon::parseFromDatetimeLocalInput($this->closing_at),
        ]);

        $this->poll->lastUpdater()->associate(Auth::user());
        $this->poll->save();
        $this->poll->events()->sync($this->selectedEvents);
    }

    public function delete(): void
    {
        $this->poll?->delete();
    }

    public function addEventsToSelection($additionalEventIdList): void
    {
        $this->selectedEvents = array_unique(array_merge($this->selectedEvents, $additionalEventIdList));
    }

    public function removeEventFromSelection($eventId): void
    {
        $this->selectedEvents = array_filter($this->selectedEvents, fn ($loopEventId) => $loopEventId != $eventId);
    }

    private function getMemberGroupId(): ?int
    {
        $memberGroupId = intval($this->memberGroup);
        if ($memberGroupId > 0) {
            return $memberGroupId;
        }

        return null;
    }
}
