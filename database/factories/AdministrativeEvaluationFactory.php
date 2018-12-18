<?php

use Faker\Generator as Faker;

$factory->define(\App\AdministrativeEvaluation::class, function (Faker $faker) {
    return [
        'session_id'  => 2,
        'attendance'  => $faker->numberBetween(1, 4),
        'punctuality' => $faker->numberBetween(1, 4),
        'remarks'     => null,
        'total'       => $faker->numberBetween(1, 4),
    ];
});
