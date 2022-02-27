<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_id' => $faker->numberBetween(0, 20),
        'title' => $faker->title,
        'description' => $faker->realText($maxNbChars = 50, $indexSize = 1),
        'cost' => $faker->randomNumber(2),
    ];
});
