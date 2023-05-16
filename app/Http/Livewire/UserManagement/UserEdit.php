<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserEdit extends Component
{
    public User $user;

    protected function rules()
    {
        return [
            'user.name' => ['required', 'string', 'min:5'],
            'user.email' => ['required', 'string', 'email', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($this->user->id)]
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function saveUser()
    {
        $this->validate();

        $this->user->save();

        session()->put('message', __("User '".$this->user->name."' saved successfully."));
        Log::info("User '".$this->user->getNameWithMail().">' has been edited by '".auth()->user()->getNameWithMail()."'");
        $this->redirect(route("userManagement.index"));
    }

    public function deleteUser()
    {
        $this->user->delete();
        session()->put("message", __("The user '".$this->user->getNameWithMail().">' has been deleted."));
        Log::info("User '".$this->user->getNameWithMail().">' has been deleted by '".auth()->user()->getNameWithMail()."'");
        $this->redirect(route("userManagement.index"));
    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
