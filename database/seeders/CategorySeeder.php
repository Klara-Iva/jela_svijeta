<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    {
        foreach (range(1, 10) as $index) {
            $category = Category::create([
                'slug' => $this->faker->unique()->slug, 
              ]);

            foreach (['en', 'fr', 'hr'] as $locale) {
                $category->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->userName(),
                      ]);
            }
        }
    }
}
