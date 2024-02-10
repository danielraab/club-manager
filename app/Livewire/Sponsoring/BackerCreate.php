<?php

namespace App\Livewire\Sponsoring;

use App\Livewire\Forms\MemberForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BackerCreate extends Component
{
    public MemberForm $memberForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->memberForm->paused = false;
        $this->memberForm->entrance_date = now()->format('Y-m-d');
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->memberForm->store();

        Log::info("Member created", [auth()->user(), $this->memberForm->member]);
        session()->put('message', __('The member has been successfully created.'));

        return redirect($this->previousUrl);
    }

    public function saveMemberAndStay(): void
    {
        $this->memberForm->store();
        Log::info("Member created", [auth()->user(), $this->memberForm->member]);
        session()->flash('savedAndStayMessage', __('New member successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.sponsoring.backer-create')->layout('layouts.backend');
    }
}
