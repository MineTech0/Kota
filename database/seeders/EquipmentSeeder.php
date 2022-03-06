<?php

namespace Database\Seeders;

use App\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipment::factory()->count(20)->create();
    }
}
