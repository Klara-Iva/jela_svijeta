<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use Illuminate\Support\Facades\DB; 

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            $category = Category::create([
                'slug' => $faker->unique()->slug,
            ]);

            foreach (['en', 'fr', 'hr'] as $locale) {
                $category->translations()->create([
                    'locale' => $locale,
                    'title' => $faker->userName(),
                ]);
            }
        }
    }
}
