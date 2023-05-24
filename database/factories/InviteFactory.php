<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $token = Str::random(32);
        
        return [
            'email' =>$this->faker->email(),
            'token' => $token,
            'url' => URL::temporarySignedRoute('create.user', now()->addWeek(), [
                'token' => $token
            ]),
        ];
    }
}
