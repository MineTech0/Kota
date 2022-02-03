<?php

namespace Database\Seeders;

use App\Group;
use Database\Factories\GroupFactory;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::factory()->count(10)->hasContact(1)->create();
    }
}
