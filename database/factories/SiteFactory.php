<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Site::class, function (Faker $faker) {
    return [
        'url'           => $faker->url,
        'access_token'  => str_random(10),
        'refresh_token' => str_random(10),
    ];
});
