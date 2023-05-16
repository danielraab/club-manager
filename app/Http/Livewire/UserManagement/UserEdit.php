<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;

class UserEdit extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
