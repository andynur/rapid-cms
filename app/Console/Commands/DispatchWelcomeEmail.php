<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;

class DispatchWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-welcome {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a welcome email to the user with the given email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            SendWelcomeEmail::dispatch($user);
            $this->info("Welcome email dispatched to user email: {$email}");
        } else {
            $this->error("User with email: {$email} not found.");
        }
    }
}
