<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'author' =>  $faker->name,
        'published_date' =>  $faker->date('Y-m-d'),
        'is_borrowed' => $isBorrowed =  $faker->boolean,
        'user' => $isBorrowed ? $faker->name : NULL,
        'category_id' => Category::all()->random()->id,
        'deleted_at' => NULL
    ];
});
