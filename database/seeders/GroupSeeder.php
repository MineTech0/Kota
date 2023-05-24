<?php

namespace Database\Seeders;

use App\Group;
use App\User;
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
        $user = User::find(1);
        Group::factory()->count(10)->hasContact(1)->create();

        $groups = Group::factory()->count(2)->create();

        foreach ($groups as $group) {
            $group->leaders()->attach($user);
        }
    }
}
