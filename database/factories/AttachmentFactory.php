<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Attachment;
use App\Interaction;
use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Attachment::class, function (Faker $faker) {
    return [
        'file' => 'TicketImage.png'
    ];
});
