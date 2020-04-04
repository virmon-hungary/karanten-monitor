<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use \Illuminate\Support\Str;
use \Faker\Provider\Base;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'taj' => Base::numberBetween(121212121,989898989),
        'phone' => '+36' . Base::numberBetween(12121212,70989989)
    ];
});

