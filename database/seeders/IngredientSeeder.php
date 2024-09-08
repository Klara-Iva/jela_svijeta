<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $ingredient = Ingredient::create([
                'slug' => $faker->unique()->slug,
            ]);

         
            foreach (['en', 'fr', 'hr'] as $locale) {
                $ingredient->translations()->create([
                    'locale' => $locale,
                    'title' => $faker->currencyCode(),
                ]);
            }
        }
    }
}
