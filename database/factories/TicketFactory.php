<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'profile_id' => factory('App\Profile'),
        'title' => $faker->sentence,
        'priority' => 'Média',
        'content' => $faker->paragraph,
        'status' => 'Em aberto',
        'respondent_id' => factory('App\User'),
    ];
});
