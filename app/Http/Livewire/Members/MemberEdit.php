<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MemberEdit extends Component
{
    use MemberTrait;

    public function mount(Member $member)
    {
        $this->member = $member;
        $this->birthday = $member->birthday?->format('Y-m-d');
        $this->entrance_date = $member->entrance_date->format('Y-m-d');
        $this->leaving_date = $member->leaving_date?->format('Y-m-d');
        $this->memberGroupList = Arr::pluck($member->memberGroups()->getResults(), 'id');
        $this->previousUrl = url()->previous();
    }

    public function saveMember()
    {
        $this->validate();
        $this->propsToModel();
        $this->member->lastUpdater()->associate(Auth::user());
        $this->member->save();

        $this->member->memberGroups()->sync(array_unique($this->memberGroupList));

        session()->put('message', __('The member has been successfully updated.'));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-edit')->layout('layouts.backend');
    }
}
