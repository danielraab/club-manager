<?php

namespace App\Livewire\Attendance;

use App\Livewire\Forms\PollForm;
use App\Models\AttendancePoll;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PollEdit extends Component
{
    public PollForm $pollForm;

    public string $previousUrl;

    public function mount(AttendancePoll $attendancePoll)
    {
        $this->pollForm->setModel($attendancePoll);
        $this->previousUrl = url()->previous();
    }

    public function savePoll()
    {
        $this->pollForm->update();

        Log::info("Poll edited", [auth()->user(), $this->pollForm->poll]);
        session()->put('message', __('The attendance poll has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function addEventsToSelection($additionalEventIdList): void
    {
        $this->pollForm->addEventsToSelection($additionalEventIdList);
    }

    public function removeEventFromSelection($eventId): void
    {
        $this->pollForm->removeEventFromSelection($eventId);
    }

    public function render()
    {
        return view('livewire.attendance.poll-edit')->layout('layouts.backend');
    }
}
