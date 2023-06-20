<?php

namespace App\Http\Livewire\Members;

use App\Models\MemberGroup;
use Illuminate\Support\Arr;
use Livewire\Component;

class MemberGroupEdit extends Component
{
    use MemberGroupTrait;

    public function mount(MemberGroup $memberGroup)
    {
        $this->memberGroup = $memberGroup;
        $this->parent = $this->memberGroup->parent()->first()?->id;
        $this->memberSelection = Arr::pluck($this->memberGroup->members()->getResults(), "id");
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        return $this->saveMemberGroupWithMessage(__('The member group has been successfully updated.'));
    }

    public function deleteMemberGroup()
    {
        $this->memberGroup->delete();
        session()->put('message', __('The member group has been successfully deleted.'));
        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.members.member-group-edit')->layout('layouts.backend');
    }
}
