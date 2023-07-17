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
        if($attendancePoll->isPublicPollAvailable()) {
            $this->poll  = $attendancePoll;
            return;
        }
        throw (new ModelNotFoundException)->setModel(
            AttendancePoll::class, $attendancePoll->id
        );
    }

    public function updatedMemberSelection(string $value) {
        if(is_numeric($value)) {
            $this->selectedMember = Member::query()->find($value);
        }
    }

    public function render()
    {
        return view('livewire.attendance.poll-public')->layout('layouts.backend');
    }
}
