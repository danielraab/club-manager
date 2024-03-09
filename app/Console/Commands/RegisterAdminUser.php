<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RegisterAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:register-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register an new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Full name of the new user?');
        $email = $this->ask('Email address of the new user?');

        $validator = validator([
            'name' => $name,
            'email' => $email,
        ], [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error) {
                if (count($error) > 0) {
                    $this->error($error[0]);
                }
            }

            return;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;

        $user->register();
        $user->userPermissions()->attach(UserPermission::ADMIN_USER_PERMISSION);

        Log::channel('userManagement')->info("User ".$user->getNameWithMail()." has been created via CLI");

        $this->info("User $email was created successfully. A welcome message with a set password link has been sent.");
    }
}
