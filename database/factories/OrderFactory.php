<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer_id'	=> rand(1,500),
        'product_id'	=> rand(1,1000),
        'qtyp'			=> rand(1,100),
        'refcode'		=> str_random(10),
        'created_by'	=> 1,
        'updated_by'	=> 1
    ];
});
