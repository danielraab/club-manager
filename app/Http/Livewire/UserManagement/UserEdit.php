<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserEdit extends Component
{
    use UserPermissionComponentTrait;

    public User $user;

    protected function rules()
    {
        return array_merge([
            'user.name' => ['required', 'string', 'min:5'],
            'user.email' => ['required', 'string', 'email',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($this->user->id)],
        ], $this->permissionRules());
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->fillPermissionArr($user);
    }

    public function saveUser()
    {
        $this->validate();

        $this->user->save();
        $this->user->userPermissions()->sync(
            $this->getSelectedPermissionKeys()
        );

        session()->put('message', __("User '" . $this->user->name . "' saved successfully."));
        Log::channel('userManagement')
            ->info("User '" . $this->user->getNameWithMail() . "' has been edited by '" . auth()->user()->getNameWithMail() . "'");
        $this->redirect(route('userManagement.index'));
    }

    public function deleteUser()
    {
        $this->user->delete();
        session()->put('message', __("The user '" . $this->user->getNameWithMail() . ">' has been deleted."));
        Log::channel('userManagement')
            ->info("User '" . $this->user->getNameWithMail() . "' has been DELETED by '" . auth()->user()->getNameWithMail() . "'");
        $this->redirect(route('userManagement.index'));
    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
