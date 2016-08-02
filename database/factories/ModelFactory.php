<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Device::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
    ];
});


$factory->define(App\Token::class, function (Faker\Generator $faker) {
    return [
        'content' => substr($faker->sha256, 0, 60),
        'expired_at' => $faker->dateTimeThisMonth
    ];
});


$factory->define(App\Measurement::class, function (Faker\Generator $faker) {
    return [
        'humidity' => $faker->randomFloat,
        'temperature' => $faker->numberBetween(-100, 100)
    ];
});
