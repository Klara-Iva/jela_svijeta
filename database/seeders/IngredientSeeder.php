<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Generator as Faker;

class IngredientSeeder extends Seeder
{

    protected $faker;

    public function __construct(Faker $faker){

    $this->faker=$faker;
    }
    public function run()
    {
        

        foreach (range(1, 10) as $index) {
            $ingredient = Ingredient::create([
                'slug' => $this->faker->unique()->slug,
            ]);

         
            foreach (['en', 'fr', 'hr'] as $locale) {
                $ingredient->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->currencyCode(),
                ]);
            }
        }
    }
}
