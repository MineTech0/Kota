<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'expense_date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'acceptor_id' => 1,
        ];
    }
}
