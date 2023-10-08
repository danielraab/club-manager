<?php

namespace App\Livewire\Members;

use App\Livewire\Forms\MemberForm;
use Livewire\Component;

class MemberCreate extends Component
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

        session()->put('message', __('The member has been successfully created.'));
        return redirect($this->previousUrl);
    }

    public function saveMemberAndStay(): void
    {
        $this->memberForm->store();
        session()->flash('savedAndStayMessage', __('New member successfully created. You can create the next one now.'));
    }

    public function render()
    {
        return view('livewire.members.member-create')->layout('layouts.backend');
    }
}
