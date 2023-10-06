<?php

namespace App\Livewire\UserManagement;

use App\Livewire\Forms\UserForm;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserCreate extends Component
{
    public UserForm $userForm;

    public string $previousUrl;

    public function mount(): void
    {
        $this->previousUrl = url()->previous();
    }

    public function saveUser()
    {
        $this->userForm->store();

        Log::channel('userManagement')->info("User '".$this->userForm->user->getNameWithMail()."' has been created by '".auth()->user()->getNameWithMail()."'");
        session()->put('message', __("User '".$this->userForm->user->name."' created successfully."));

        return redirect($this->previousUrl);
    }

    public function render()
    {
        return view('livewire.user-management.user-create')->layout('layouts.backend');
    }
}
