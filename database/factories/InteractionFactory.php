<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Interaction;
use Faker\Generator as Faker;

$factory->define(Interaction::class, function (Faker $faker) {
    return [
        'ticket_id' => factory('App\Ticket'),
        'user_id' => factory('App\User'),
        'content' => $faker->paragraph
    ];
});
