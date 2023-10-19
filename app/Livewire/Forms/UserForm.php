<?php

namespace App\Livewire\Forms;

use App\Livewire\UserManagement\UserPermissionComponentTrait;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    use UserPermissionComponentTrait;

    public ?User $user = null;

    #[Rule('required|min:5')]
    public string $name;
    public string $email;

    public function setUserModel(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->fillPermissionArr($user);
    }

    public function delete(): void
    {
        $this->user->delete();
    }


    protected function rules(): array
    {
        $emailRule = ['required', 'string', 'email', 'unique:users,email'];
        if($this->user)
        {
            $emailRule = [
                'required', 'string', 'email',
                \Illuminate\Validation\Rule::unique('users', 'email')->ignore($this->user->id)
            ];
        }

        return [
            'email' => $emailRule,
            ...$this->permissionRules()
        ];
    }

    public function store(): void
    {
        $this->validate();

        $this->user = User::create([
            "name" => $this->name,
            "email" => $this->email
        ]);

        $this->user->register();
        $this->user->userPermissions()->sync(
            $this->getSelectedPermissionKeys()
        );
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            "name" => $this->name,
            "email" => $this->email
        ]);

        $this->user->userPermissions()->sync(
            $this->getSelectedPermissionKeys()
        );
    }
}
