<?php

namespace App\Livewire\Members;

use App\Livewire\Forms\MemberGroupForm;
use App\Models\MemberGroup;
use Illuminate\Support\Arr;
use Livewire\Component;

class MemberGroupEdit extends Component
{
    public MemberGroupForm $memberGroupForm;
    public string $previousUrl;

    public function mount(MemberGroup $memberGroup): void
    {
        $this->memberGroupForm->setModel($memberGroup);
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        $this->memberGroupForm->update();

        session()->put('message', __('The member group has been successfully updated.'));
        return redirect($this->previousUrl);
    }

    public function deleteMemberGroup()
    {
        $this->memberGroupForm->delete();

        session()->put('message', __('The member group has been successfully deleted.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-group-edit')->layout('layouts.backend');
    }
}
