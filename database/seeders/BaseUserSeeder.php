<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class BaseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managementUser = User::factory()->create([
            'email' => 'management@email.com',
        ]);

        $managementUser->assignRole('management');

        $adminUser = User::factory()->create([
            'email' => 'admin@email.com',
        ]);

        $adminUser->assignRole('super-admin');
    }
}
