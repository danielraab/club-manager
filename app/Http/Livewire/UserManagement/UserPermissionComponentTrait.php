<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;

trait UserPermissionComponentTrait
{
    public array $permissionArr = [];


    protected function permissionRules(): array
    {
        return ['permissionArr' => ['array', 'nullable']];
    }

    protected function fillPermissionArr(User $user): void
    {
        foreach ($user->userPermissions()->pluck("id")->toArray() as $permissionKey) {
            $this->permissionArr[$permissionKey] = true;
        }
    }

    /**
     * @return string[]
     */
    protected function getSelectedPermissionKeys(): array
    {
        return array_keys(
            array_filter($this->permissionArr, function ($elem) {
                return $elem === true;
            })
        );
    }
}
