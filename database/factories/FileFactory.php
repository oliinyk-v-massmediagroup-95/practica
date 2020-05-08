<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\File::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'type' => 'image',
        'name' => '',
        'ext' => 'jpeg',
        'path' => '',
        'original_name' => '',
    ];
});
