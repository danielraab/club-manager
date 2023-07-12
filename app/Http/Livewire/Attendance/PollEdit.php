<?php

namespace App\Http\Livewire\Attendance;

use App\Models\AttendancePoll;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PollEdit extends Component
{
    use PollTrait;

    public function mount(AttendancePoll $attendancePoll)
    {
        $this->poll = $attendancePoll;
        $this->closing_at = $this->poll->closing_at->formatDatetimeLocalInput();
        $this->selectedEvents = $this->poll->events()->pluck("id")->toArray();
        $this->previousUrl = url()->previous();
    }

    public function savePoll()
    {
        $this->validate();
        $this->propToModel();
        $this->poll->lastUpdater()->associate(Auth::user());
        $this->poll->save();
        $this->poll->events()->sync($this->selectedEvents);

        session()->put('message', __('The attendance poll has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.attendance.poll-edit')->layout('layouts.backend');
    }
}
