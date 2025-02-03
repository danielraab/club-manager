<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPermission;
use App\Services\NewUserProvider;
use App\Services\UserService;
use Illuminate\Console\Command;

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

    public function __construct(private readonly UserService $userService)
    {
        parent::__construct();
    }

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

        $user = $this->userService->createUser($email, $name, NewUserProvider::CLI);
        $user->email_verified_at = now();
        $user->save();

        $user->userPermissions()->attach(UserPermission::ADMIN_USER_PERMISSION);
        $user->sendWelcomeNotification(now()->addWeek());
        $this->info("User $email was created successfully. A welcome message with a set password link has been sent.");
    }
}
