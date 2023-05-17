<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserCreate extends Component
{
    use UserPermissionComponentTrait;

    public User $user;

    protected function rules()
    {
        return array_merge([
            'user.name' => ['required', 'string', 'min:5'],
            'user.email' => ['required', 'string', 'email', 'unique:users,email'],
        ], $this->permissionRules());
    }

    public function mount()
    {
        $this->user = new User();
    }

    public function saveUser()
    {
        $this->validate();

        $this->user->register();
        $this->user->userPermissions()->sync(
            $this->getSelectedPermissionKeys()
        );

        session()->put('message', __("User '".$this->user->name."' created successfully."));
        Log::channel('userManagement')->info("User '".$this->user->getNameWithMail()."' has been created by '".auth()->user()->getNameWithMail()."'");
        $this->redirect(route('userManagement.index'));
    }

    public function render()
    {
        return view('livewire.user-management.user-create')->layout('layouts.backend');
    }
}
