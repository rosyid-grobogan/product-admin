<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'brand' => $faker->randomElement(['deenay', 'zahira', 'syariya', 'nike']),
        'description' => $faker-> sentence(40),
        'category_id' => App\Models\Category::inRandomOrder()->first()->id
    ];
});
