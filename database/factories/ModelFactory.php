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

$factory->define(App\Models\Person::class, function (Faker\Generator $faker) {
    return [
        'first' => $faker->firstName,
        'last' => $faker->lastName,
        'deleted_at' => null
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->safeEmail,
        'person_id' => factory(App\Models\Person::class)->create()->id,
        'password' => $password ?: $password = bcrypt('secret'),
        'api_token' => str_random(60),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Exp::class, function (\Faker\Generator $faker) {
    return [
        'user_id' => factory(App\Models\User::class)->create()->id,
        'type' => 'default',
        'title' => $faker->jobTitle,
        'subtitle' => $faker->sentence,
        'deleted_at' => null
    ];
});


$factory->define(App\Models\Skill::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->name,
        'creator_id' => factory(App\Models\User::class)->create()->id,
        'deleted_at' => null
    ];
});
