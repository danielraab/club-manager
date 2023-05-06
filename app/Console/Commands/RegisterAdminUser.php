<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

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
            "name" => "required|min:5",
            "email" => "required|email|unique:users"
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

        $this->info("User $email was created successfully. Require a password via the password forgot page.");
    }
}
