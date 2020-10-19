<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph(5),
        'user_id' => App\User::all()->random()->id,
        'channel_id' => \App\Channel::all()->random()->id,
    ];
});
