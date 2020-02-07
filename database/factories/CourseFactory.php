<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;


$factory->define(Course::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence,
        'note' => $faker->sentence,
        'code' => $faker->numberBetween(10, 1000),
        'lecturer' => $faker->word
    ];
});


