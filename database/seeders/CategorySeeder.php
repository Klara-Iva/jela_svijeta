<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    protected $faker;
    protected $lagunages;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    {
        $languages = DB::table('languages')->pluck('code');
        foreach (range(1, 10) as $index) {
            $category = Category::create([
                'slug' => $this->faker->unique()->slug, 
              ]);

            foreach ($languages as $locale) {
                $category->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->userName(),
                      ]);
            }
        }
    }
}
