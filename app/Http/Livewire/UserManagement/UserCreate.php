<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;

class UserCreate extends Component
{

    public function render()
    {
        return view('livewire.user-management.user-create')->layout('layouts.backend');
    }
}
