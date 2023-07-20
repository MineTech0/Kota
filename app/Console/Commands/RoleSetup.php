<?php

namespace App\Console\Commands;

use Database\Seeders\RoleSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Contracts\Role;

class RoleSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds roles and permissions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $output =  Artisan::call("db:seed", [
            "--class" => RoleSeeder::class,
            "--force" => true
        ]);
        if($output == 0) {
            $this->info("Roles and permissions created!");
            return Command::SUCCESS;
        }
        else {
            $this->error("Roles and permissions creation failed!");
            return Command::FAILURE;
        }
    }
}
