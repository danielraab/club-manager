<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use App\Models\UserPermission;

trait UserPermissionComponentTrait
{
    public array $permissionArr = [];


    protected function permissionRules(): array
    {
        return [
            'permissionArr' => ['array', 'nullable',
                function (string $attribute, mixed $value, \Closure $fail) {
                    self::permissionsAvailableCheck($attribute, $value, $fail);
                }]
        ];
    }

    private static function permissionsAvailableCheck(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_array($value)) {
            $possiblePermissions = UserPermission::all('id')->pluck('id')->toArray();
            if (count(array_diff(array_keys($value), $possiblePermissions)) > 0) {
                $fail("Some selected permissions are not valid. Please refresh the page.");
            }
        }
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
