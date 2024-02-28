<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Recipes;
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
       //create 5 categorie and each category ha 20 recipes

       Category::factory(5)
       ->has(Recipes::factory()->count(20), 'recipes')
       ->create();
    }
}
