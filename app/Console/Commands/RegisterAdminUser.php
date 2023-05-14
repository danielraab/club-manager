<?php

namespace App\Console\Commands;

use App\Auth\PasswordBroker;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;

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
            "name" => $name,
            "email" => $email
        ], [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class]
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $error) {
                if (count($error) > 0) $this->error($error[0]);
            }
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
        ]);

        event(new Registered($user));

        $expiresAt = now()->addWeek();
        $user->sendWelcomeNotification($expiresAt);

        $this->info("User $email was created successfully. A welcome message with a set password link has been sent.");
    }
}
