<?php

namespace App\Livewire\UserManagement;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserEdit extends Component
{
    use UserPermissionComponentTrait;

    public User $user;

    public string $previousUrl;

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
        $this->previousUrl = url()->previous();
    }

    public function saveUser()
    {
        $this->validate();

        $this->user->save();
        $this->user->userPermissions()->sync(
            $this->getSelectedPermissionKeys()
        );

        Log::channel('userManagement')
            ->info("User '".$this->user->getNameWithMail()."' has been edited by '".auth()->user()->getNameWithMail()."'");
        session()->put('message', __("User '".$this->user->name."' saved successfully."));

        return redirect($this->previousUrl);
    }

    public function deleteUser()
    {
        $this->user->delete();
        Log::channel('userManagement')
            ->info("User '".$this->user->getNameWithMail()."' has been DELETED by '".auth()->user()->getNameWithMail()."'");

        return back()->with('message', __("The user '".$this->user->getNameWithMail()."' has been deleted."));
    }

    public function render()
    {
        return view('livewire.user-management.user-edit')->layout('layouts.backend');
    }
}
