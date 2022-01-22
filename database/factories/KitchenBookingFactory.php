<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KitchenBookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startTime = now()->format('Y-m-d\TH:i');
        $endTime = now()->addHour()->format('Y-m-d\TH:i');
        return [
            'user_id' => 1,
            'group_name' => $this->faker->word(),
            'start_time' => $startTime,
            'end_time' => $endTime
        ];
    }
}
