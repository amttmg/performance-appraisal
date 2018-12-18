<?php

use Faker\Generator as Faker;

$factory->define(\App\WorkEvaluation::class, function (Faker $faker) {
    return [
        'session_id'   => 2,
        'efficiency'   => $faker->numberBetween(1, 4),
        'productivity' => $faker->numberBetween(1, 4),
        'total'        => $faker->numberBetween(1, 4),
        'remarks'      => null,
    ];
});
