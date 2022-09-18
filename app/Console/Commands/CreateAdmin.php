<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archivit:createadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create administrator account for web interface';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret("Password");
        $password_repeat = $this->secret("Repeat password");

        if($password === $password_repeat){
            $creating_user = User::insert([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            if($creating_user){
                $this->info(sprintf("User %s was created successfully!", $username));
            } else {
                $this->error("An error has occurred while creating user");
            }
        } else {
            $this->error("Passwords are not identical");
        }
        return 0;
    }
}
