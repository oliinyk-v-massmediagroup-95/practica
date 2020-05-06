<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\File::class, function (Faker $faker) {
    return [
        'user_id' => 0,
        'type' => 'image',
        'name' => '',
        'ext' => 'jpeg',
        'path' => '',
        'original_name' => '',
    ];
});
