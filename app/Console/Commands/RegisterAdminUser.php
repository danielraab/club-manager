<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SetPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
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

        $status = Password::sendSetLink(
            ["email" => $email]
        );
        if($status !== Password::RESET_LINK_SENT) {
            $this->error("Error while sending the mail: $status");
        }

        $this->info("User $email was created successfully. Require a password via the password forgot page.");
    }
}
