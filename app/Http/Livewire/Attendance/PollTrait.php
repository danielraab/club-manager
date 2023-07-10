<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendancePoll;
use App\Models\Event;
use Carbon\Carbon;
use function Deployer\add;

trait PollTrait
{

    public AttendancePoll $poll;
    public string $closing_at;
    public string $previousUrl;

    /** @var int[] */
    public array $eventList = [];

    protected array $rules = [
        'poll.title' => ['required', 'string', 'max:255'],
        'poll.description' => ['nullable', 'string'],
        'poll.enabled' => ['nullable', 'boolean'],
        'poll.allow_anonymous_vote' => ['nullable', 'boolean'],
        'eventList' => ['required', 'array'],
        'closing_at' => ['required', 'date'],
    ];

    protected function propToModel() {
        $this->poll->closing_at = Carbon::parseFromDatetimeLocalInput($this->closing_at);
    }

    public function addEventList($additionalEventIdList) {

        $this->eventList = array_unique( array_merge($this->eventList, $additionalEventIdList));
    }
}
