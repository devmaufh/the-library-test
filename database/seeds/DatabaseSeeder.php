<?php

use App\Models\Book;
use App\Models\Category;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 10)->create();
        factory(Book::class, 100)->create();
    }
}
