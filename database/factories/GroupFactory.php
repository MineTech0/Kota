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
        $ages = ['Sudenpennut, 1v', 'Sudenpennut, 2v', 'Seikkailijat, 1v', 'Seikkailijat, 2v', 'Seikkailijat, 3v', 'Tarpojat, 1v', 'Tarpojat, 2v', 'Tarpojat, 3v'];
        $leaders = array();
        for ($i = 0; $i < 3; $i++) {
            $leaders[] = $this->faker->name();
        }
        return [
            'name' => $this->faker->firstName(),
            'leaders' => implode(',', $leaders),
            'day' => $weekdays[array_rand($weekdays, 1)],
            'time' => '18:00-19:00',
            'repeat' => 'Viikoittain',
            'age' => $ages[array_rand($ages,1)],
        ];
    }
}
