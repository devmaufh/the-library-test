<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'author' =>  $faker->name,
        'published_date' =>  $faker->date('Y-m-d'),
        'user' => $faker->name,
        'is_borrowed' => $faker->boolean,
        'category_id' => Category::all()->random()->id,
        'deleted_at' => NULL
    ];
});
