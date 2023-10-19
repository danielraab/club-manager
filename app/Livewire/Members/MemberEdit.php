<?php

namespace App\Livewire\Members;

use App\Livewire\Forms\MemberForm;
use App\Models\Member;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberEdit extends Component
{
    public MemberForm $memberForm;
    public string $previousUrl;

    public function mount(Member $member): void
    {
        $this->memberForm->setMemberModal($member);
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->memberForm->update();

        session()->put('message', __('The member has been successfully updated.'));
        return redirect($this->previousUrl);
    }

    public function deleteMember() {

        $this->memberForm->delete();

        session()->put('message', __('The member has been successfully deleted.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-edit')->layout('layouts.backend');
    }
}
