<?php

namespace App\Livewire\Attendance;

use App\Models\AttendancePoll;
use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PollPublic extends Component
{
    public AttendancePoll $poll;

    public string $memberSelection = '';

    public ?Member $selectedMember = null;

    protected array $rules = [
        'selectedMember' => ['nullable', 'string'],
    ];

    public function mount(AttendancePoll $attendancePoll)
    {
        if ($attendancePoll->isPublicPollAvailable()) {
            $this->poll = $attendancePoll;

            return;
        }
        throw (new ModelNotFoundException)->setModel(
            AttendancePoll::class, $attendancePoll->id
        );
    }

    public function updatedMemberSelection(string $value)
    {
        if (is_numeric($value)) {
            $this->selectedMember = Member::query()->find($value);
        }
    }

    public function setAttendance(int $eventId, string $result): void
    {
        if ($this->selectedMember) {
            /** @var \App\Models\Attendance $attendance */
            $attendance = \App\Models\Attendance::query()->firstOrCreate([
                'event_id' => $eventId,
                'member_id' => $this->selectedMember->id,
            ], [
                'creator_id' => auth()->user()?->id ?? null,
            ]);
            $attendance->poll_status = $result;
            $attendance->save();
            Log::info('Attendance set via public poll', [$attendance]);
        }
    }

    public function resetSelected(): void
    {
        $this->selectedMember = null;
        $this->memberSelection = '';
    }

    public function render()
    {
        return view('livewire.attendance.poll-public')->layout('layouts.backend');
    }
}
