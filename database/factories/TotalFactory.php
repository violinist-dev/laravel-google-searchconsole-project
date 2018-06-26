<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Total::class, function (Faker $faker) {
    return [
        'month'       => $faker->dateTimeThisMonth,
        'clicks'      => $faker->randomDigitNotNull,
        'impressions' => $faker->randomDigitNotNull,
        'ctr'         => $faker->randomDigitNotNull,
        'position'    => $faker->randomDigitNotNull,
        'memo'        => str_random(10),
        'memo_at'     => $faker->dateTime,
    ];
});
