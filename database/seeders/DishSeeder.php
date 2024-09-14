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

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    {

        $languages = DB::table('languages')->pluck('code');
        //Faker doesnt have databse for food names and descriptions,
        //therefore for testing purposes, the data is filled with random words, 
        //mostly in English


        foreach (range(1, 30) as $index) {
            $categoryId = $this->faker->boolean(70) ? Category::inRandomOrder()->first()->id : null;

            $createdAt = $this->faker->dateTimeBetween('-11 years', 'now');
            $updatedAt = null;
            $deletedAt = null;

            $status = $this->faker->randomElement(['created', 'modified', 'deleted']);

            if ($status === 'created') {
                $updatedAt = null;
                $deletedAt = null;
            } elseif ($status === 'modified') {
                $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');
            } elseif ($status === 'deleted') {
                $time = $this->faker->dateTimeBetween($createdAt, 'now');
                $deletedAt = $time;
                $updatedAt = $time;
            }

            $dish = Dish::create([
                'status' => $status,
                'category_id' => $categoryId,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'deleted_at' => $deletedAt,
            ]);

            foreach ($languages as $locale) {
                $dish->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->lexify('????????'),
                    'description' => $this->faker->realText(60),
                ]);
            }

            $tags = Tag::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->pluck('id');
            $dish->tags()->attach($tags);

            $ingredients = Ingredient::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->pluck('id');
            $dish->ingredients()->attach($ingredients);
        }
    }
}
