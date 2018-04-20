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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'address' => $faker->secondaryAddress(),
        'work_number' => $faker->randomNumber(8),
        'personal_number' => $faker->phoneNumber(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Athlete::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'vat' => $faker->randomNumber(8),
        'company_name' => $faker->company(),
        'address' => $faker->secondaryAddress(),
        'city' => $faker->city(),
        'state'=> $faker->state(),
        'zipcode' => $faker->postcode(),
        'primary_number' => $faker->phoneNumber,
        'secondary_number' => $faker->phoneNumber,
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
        'company_type' => 'ApS',
    ];
});



$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->realText,
        'description' => $faker->paragraph,
        'user_created_id' => $faker->numberBetween($min = 1, $max = 3),
        'user_assigned_id' => $faker->numberBetween($min = 1, $max = 3),
        'athlete_id' => $faker->numberBetween($min = 1, $max = 50),
        'status' => $faker->numberBetween($min = 1, $max = 2),
        'deadline' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});

$factory->define(App\Models\Recruit::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->realText,
        'description' => $faker->paragraph,
        'user_created_id' => $faker->numberBetween($min = 1, $max = 3),
        'user_assigned_id' => $faker->numberBetween($min = 1, $max = 3),
        'athlete_id' => $faker->numberBetween($min = 1, $max = 50),
        'status_id' => $faker->numberBetween($min = 1, $max = 4),
        'contact_date' => $faker->dateTimeThisYear($max = 'now'),
        'created_at' => $faker->dateTimeThisYear($max = 'now'),
        'updated_at' => $faker->dateTimeThisYear($max = 'now'),
    ];
});
