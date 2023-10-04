<?php

namespace App\Livewire\Attendance;

use App\Models\AttendancePoll;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PollCreate extends Component
{
    use PollTrait;

    public function mount()
    {
        $this->poll = new AttendancePoll();
        $this->poll->allow_anonymous_vote = true;
        $this->poll->closing_at = now()->addWeek()->setMinute(0)->setSecond(0);
        $this->closing_at = $this->poll->closing_at->formatDatetimeLocalInput();
        $this->previousUrl = url()->previous();
    }

    public function savePoll()
    {
        $this->validate();
        $this->propToModel();
        $this->poll->creator()->associate(Auth::user());
        $this->poll->lastUpdater()->associate(Auth::user());
        $this->poll->save();
        $this->poll->events()->sync($this->selectedEvents);

        session()->put('message', __('The attendance poll has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.attendance.poll-create')->layout('layouts.backend');
    }
}
