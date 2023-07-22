<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendancePoll;
use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class PollPublic extends Component
{
    public AttendancePoll $poll;
    public string $memberSelection = "";
    public Member|null $selectedMember = null;

    protected array $rules = [
        "selectedMember" => ["nullable", "string"]
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
                "event_id" => $eventId,
                "member_id" => $this->selectedMember->id
            ], [
                "creator_id" => auth()->user()?->id ?? null
            ]);
            $attendance->poll_status = $result;
            $attendance->save();
        }
    }

    public function render()
    {
        return view('livewire.attendance.poll-public')->layout('layouts.backend');
    }
}
