<?php

namespace App\Livewire\Forms;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

    #[Validate('required|date')]
    public string $start;

    #[Validate('required|date|after_or_equal:start')]
    public string $end;

    #[Validate('nullable|int|exists:event_types,id')]
    public ?string $type = null;

    #[Validate('nullable|int|exists:member_groups,id')]
    public ?string $member_group_id = null;

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

    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->validate();

        $this->event = Event::query()->create($this->getParamsForDB())->first();

        $this->event->creator()->associate(Auth::user());
        $this->event->lastUpdater()->associate(Auth::user());

        $this->event->save();
    }

    private function getParamsForDB(): array
    {
        return [...$this->except(['event', 'start', 'end', 'type', 'member_group_id']),
            'start' => Carbon::parseFromDatetimeLocalInput($this->start),
            'end' => Carbon::parseFromDatetimeLocalInput($this->end),
            'event_type_id' => $this->getIdOrNull($this->type),
            'member_group_id' => $this->getIdOrNull($this->member_group_id),
        ];
    }

    /**
     * @throws ValidationException
     */
    public function update(): void
    {
        $this->validate();

        $this->event->update($this->getParamsForDB());
        $this->event->lastUpdater()->associate(Auth::user());

        $this->event->save();
    }

    /**
     * @param  Carbon[]  $dateArray
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function copy(array $dateArray): void
    {
        $this->update();
        $start = $this->event->start;
        $diff = $this->event->end->diff($start);

        $eventData = [];
        foreach ($dateArray as $copyDate) {
            $newStart = (new Carbon($copyDate))->setTime($start->hour, $start->minute);
            $newEnd = $newStart->clone()->add($diff);
            $params = $this->getParamsForDB();
            $params['start'] = $newStart;
            $params['end'] = $newEnd;
            $eventData[] = $params;
        }

        Event::query()->insert($eventData);
    }

    private function getIdOrNull(null|string|int $id): ?int
    {
        $eventTypeId = intval($id);
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

        $this->start = $event->start->formatDatetimeLocalInput();
        $this->end = $event->end->formatDatetimeLocalInput();
        $this->type = $event->event_type_id;
        $this->member_group_id = $event->member_group_id;
    }

    public function delete(): void
    {
        $this->event?->delete();
    }
}
