<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
	static $product_id = 1;
    return [
        'path'	=> 'upload_img/mtyWAURm4ugY8qvf7QSb5rcI7khg982NlnlQhQoK.png',
        'product_id' => $product_id++
    ];
});
