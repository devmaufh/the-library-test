<?php

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
        User::create([
            'name' => 'Mauricio Flores Hernandez',
            'email' => 'mau1361317@gmail.com',
            'password' => bcrypt('hola'),
        ]);
        factory(User::class, 20)->create();
    }
}
