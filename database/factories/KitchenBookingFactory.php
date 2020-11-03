<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\KitchenBooking;
use Faker\Generator as Faker;

$factory->define(KitchenBooking::class, function (Faker $faker) {
    $startTime = now()->format('Y-m-d\TH:i');
    $endTime = now()->addHour()->format('Y-m-d\TH:i');
    return [
        'user_id' => 1,
        'group_name' => $faker->word(),
        'start_time' => $startTime,
        'end_time' => $endTime
    ];
});
