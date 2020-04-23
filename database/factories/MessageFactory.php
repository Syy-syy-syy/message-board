<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'content' => $faker->sentence(10),
    ];
});
