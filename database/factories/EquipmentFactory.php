<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
     
    public function definition()
    {
        $forms = ['Hyvä','Kulunut','Uusi','Huono']; //Rikkki

        return [
            'name' => $this->faker->word(),
            'weight'=> $this->faker->numberBetween(0,10),
            'form'=> $this->faker->randomElement($forms),
            'location'=> 'Pappila/'. strtoupper($this->faker->randomLetter()) . $this->faker->numberBetween(1,9),
            'quantity'=>$this->faker->numberBetween(1,10),
            'loan_time'=> 7,
            'info'=> $this->faker->sentence(),
            'serial'=> '#'. strtoupper($this->faker->randomLetter()) . strtoupper($this->faker->randomLetter()) . $this->faker->numberBetween(1,9),
            'picture'=> null,
        ];
    }
}
