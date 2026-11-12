<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email : Login email} {--name= : Display name}';

    protected $description = 'Create (or reset the password of) an admin who can sign in at /admin';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('That is not a valid email address.');

            return self::FAILURE;
        }

        $password = $this->secret('Password (min 12 characters)');

        if (strlen((string) $password) < 12) {
            $this->error('The password must be at least 12 characters.');

            return self::FAILURE;
        }

        if ($password !== $this->secret('Repeat the password')) {
            $this->error('The passwords do not match.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $existed = $user->exists;
        $user->name = $this->option('name') ?: ($user->name ?: 'Admin');
        $user->password = $password; // hashed by the model cast
        $user->save();

        $this->info($existed ? "Password updated for {$email}." : "Admin {$email} created. Sign in at /admin.");

        return self::SUCCESS;
    }
}
