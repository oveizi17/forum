<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(1),
        'user_id' => App\User::all()->random()->id,
        'thread_id' => App\Thread::all()->random()->id,
    ];
});
