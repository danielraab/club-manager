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
