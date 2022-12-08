<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(BaseUserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(FileSeeder::class);


    }
}
