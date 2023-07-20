<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //if admin exits error
       $adminUser = User::with("roles")->whereHas("roles", function($q) {
            $q->whereIn("name", ["super-admin"]);
        })->get();

        if ($adminUser->count() > 0) {
            $this->error('Admin user already exists!');
            return Command::FAILURE;
        }

        //check if super-admin role exists
        $role = Role::where("name", "super-admin")->first();
        if (!$role) {
            $this->error('Super-admin role does not exist!');
            return Command::FAILURE;
        }


        $email = $this->ask('Admin email?');
        $password = $this->secret('Admin password?');
        $name = $this->ask('Admin name?');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('super-admin');

        $this->info('Admin user created!');

        return Command::SUCCESS;
    }
}
