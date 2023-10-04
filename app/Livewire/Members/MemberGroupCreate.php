<?php

namespace App\Livewire\Members;

use App\Models\MemberGroup;
use Livewire\Component;

class MemberGroupCreate extends Component
{
    use MemberGroupTrait;

    public function mount()
    {
        $this->memberGroup = new MemberGroup();
        $this->previousUrl = url()->previous();
    }

    public function saveMemberGroup()
    {
        return $this->saveMemberGroupWithMessage(__('The member group has been successfully created.'));
    }

    public function render()
    {
        return view('livewire.members.member-group-create')->layout('layouts.backend');
    }
}
