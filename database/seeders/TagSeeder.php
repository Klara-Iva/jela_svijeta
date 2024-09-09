<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); //TODO, make the Faker as a singleton

        foreach (range(1, 10) as $index) {
            $tag = Tag::create([
                'slug' => $faker->unique()->slug,  
                //TODO->change the tags to numbers 
                //filtering is done with tags id!!!
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
