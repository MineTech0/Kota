<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()

    {
        $weekdays = ['Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su'];
        $ages = config('kota.groups.ageGroups');
        return [
            'name' => $this->faker->firstName(),
            'meeting_day' => $weekdays[array_rand($weekdays, 1)],
            'meeting_start' => '18:00',
            'meeting_end' => '19:00',
            'repeat' => 'Viikoittain',
            'age' => $ages[array_rand($ages,1)],
            'member_count' => $this->faker->numberBetween(1, 20),
        ];
    }
}
