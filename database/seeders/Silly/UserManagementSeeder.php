<?php

namespace Database\Seeders\Silly;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserManagementSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $userShow;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public mixed $userEdit;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->addUsers();

    }

    private function addUsers()
    {

        /** @var User $userShow */
        $this->userShow = \App\Models\User::factory()->create([
            'name' => 'User Show User',
            'email' => 'showUser@draab.at',
            'password' => Hash::make('showUser'),
        ]);
        $this->userShow->userPermissions()->attach(UserPermission::USER_MANAGEMENT_SHOW_PERMISSION);

        $this->userEdit = \App\Models\User::factory()->create([
            'name' => 'User Edit User',
            'email' => 'editUser@draab.at',
            'password' => Hash::make('editUser'),
        ]);
        $this->userEdit->userPermissions()->attach(UserPermission::USER_MANAGEMENT_EDIT_PERMISSION);
    }
}
