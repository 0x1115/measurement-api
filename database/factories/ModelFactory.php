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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => app('hash')->make((str_random(10))),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'production', function (Faker\Generator $faker) {
    return [
        'name' => 'Developer',
        'email' => 'dev@app.dev',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Device::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'mac_address' => $faker->macAddress
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
        'humidity' => $faker->randomFloat(null, 0, 1),
        'temperature' => $faker->randomFloat(null, -200, 200)
    ];
});
