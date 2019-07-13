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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
//$faker 一个库
$factory->define(App\Blog::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text(100),
        'user_id' => $faker->randomElement([1, 2, 3])
    ];
});
