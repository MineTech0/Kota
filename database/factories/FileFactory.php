<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = ['Mallipohja', 'Ohje', 'Asiakirja'];
        $type = $this->faker->randomElement(['url', 'file']);

        return [
            'name' => $this->faker->word(),
            'category'=> $this->faker->randomElement($categories),
            'path'=> $type == 'file' ? 'testFile.txt' : 'https://www.is.fi/',
            'permission'=> null,
            'isUrl'=> $type == 'url',
        ];
    }
}
