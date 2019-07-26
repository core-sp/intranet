<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'title' => $faker->sentence,
        'priority' => 'Média',
        'content' => $faker->paragraph,
        'profile_id' => factory('App\Profile')
    ];
});
