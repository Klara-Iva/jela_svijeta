<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    protected $faker;
protected $languages;
    public function __construct(Faker $faker){ $this->faker=$faker;}

    public function run()
    {
        $languages = DB::table('languages')->pluck('code');

        foreach (range(1, 10) as $index) {
            $tag = Tag::create([
                'slug' => $this->faker->unique()->slug,  
                //TODO->change the tags to numbers??
                //filtering is done with tags id!!!
            ]);

          
            foreach ($languages as $locale) {
                $tag->translations()->create([
                    'locale' => $locale,
                    'title' => $this->faker->safeColorName(),
                ]);
            }
        }
    }
}
