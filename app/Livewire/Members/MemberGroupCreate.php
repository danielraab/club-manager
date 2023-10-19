<?php

namespace App\Livewire\Members;

use App\Livewire\Forms\MemberGroupForm;
use Livewire\Component;

class MemberGroupCreate extends Component
{
    public MemberGroupForm $memberGroupForm;
    public string $previousUrl;

    public function mount(): void
    {
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        $this->memberGroupForm->store();

        session()->put('message', __('The member group has been successfully created.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-group-create')->layout('layouts.backend');
    }
}
