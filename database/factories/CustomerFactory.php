<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'alias_name' => $faker->name,
        'email' => $faker->email,
        'phone_no' => $faker->tollFreePhoneNumber,
        'address_id' => 1
    ];
});


