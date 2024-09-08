<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $tag = Tag::create([
                'slug' => $faker->unique()->slug,
            ]);

          
            foreach (['en', 'fr', 'hr'] as $locale) {
                $tag->translations()->create([
                    'locale' => $locale,
                    'title' => $faker->safeColorName(),
                ]);
            }
        }
    }
}
