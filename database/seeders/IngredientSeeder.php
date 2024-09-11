<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;


class IngredientSeeder extends Seeder
{
    protected $faker;
    protected $languages;
    public function __construct(Faker $faker)
    {
        $this->faker=$faker;
    }

    public function run()
    {
        $languages = DB::table('languages')->pluck('code');
       
        foreach (range(1, 10) as $index) {
            $ingredient = Ingredient::create([
                'slug' => $this->faker->unique()->slug,
            ]);

         
            foreach ($languages as $locale) {
                $ingredient->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->currencyCode(),
                ]);
            }
        }
    }
}
