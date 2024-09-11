<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class DishSeeder extends Seeder
{
     protected $faker;
protected $languages;
     public function __construct(Faker $faker){
        $this->faker=$faker;
        
     }
    public function run()
    {

        $languages = DB::table('languages')->pluck('code');
        //Faker doesnt have databse for food names and descriptions,
        //therefore for testing purposes, the data is filled with random words, 
        //mostly in English
      

        foreach (range(1, 10) as $index) {
            $categoryId = $this->faker->boolean(70) ? Category::inRandomOrder()->first()->id : null;

            $dish = Dish::create([
                'status' => $this->faker->randomElement(['created', 'updated', 'deleted']),
                'category_id' => $categoryId,
            ]);

            foreach ($languages as $locale) {


                //Local faker used beacuse its needed for different languages
                $localeFaker = \Faker\Factory::create($locale);


                
                $dish->translations()->create([
                    'locale' => $locale,
                    'title' => $localeFaker->lexify('????????'),
                    'description' => $localeFaker->realText(60),
                ]);
            }

            $tags = Tag::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->pluck('id');
            $dish->tags()->attach($tags);

            $ingredients = Ingredient::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->pluck('id');
            $dish->ingredients()->attach($ingredients);
        }
    }
}
