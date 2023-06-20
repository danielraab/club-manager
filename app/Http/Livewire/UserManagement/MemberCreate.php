<?php

namespace App\Http\Livewire\UserManagement;

use App\Http\Livewire\Members\MemberTrait;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberCreate extends Component
{
    use MemberTrait;

    public function mount()
    {
        $this->member = new Member();
        $this->entrance_date = now()->format("Y-m-d");
        $this->member->creator()->associate(Auth::user());
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->validate();
        $this->propsToModel();
        $this->member->creator()->associate(Auth::user());
        $this->member->lastUpdater()->associate(Auth::user());
        $this->member->save();

        session()->put('message', __('The member has been successfully created.'));
        return redirect($this->previousUrl);
    }

    public function saveMemberAndStay() {
        $this->validate();
        $this->propsToModel();
        $this->member->creator()->associate(Auth::user());
        $this->member->lastUpdater()->associate(Auth::user());
        $this->member->replicate()->save();

        session()->flash("savedAndStayMessage", __("New member successfully created. You can create the next one now."));
    }

    public function render()
    {
        return view('livewire.members.member-create')->layout('layouts.backend');
    }
}
