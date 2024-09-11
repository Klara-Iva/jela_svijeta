<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class SeederHelper
{
    public static function createWithTranslations(
        string $modelClass,
        string $titleMethod,
        Faker $faker
    ) {
        $languages = DB::table('languages')->pluck('code');

        foreach (range(1, 10) as $index) {
            $modelInstance = $modelClass::create([
                'slug' => $faker->unique()->slug,
            ]);

            foreach ($languages as $locale) {
                $modelInstance->translations()->create([
                    'locale' => $locale,
                    'title' => $faker->$titleMethod(),
                ]);
            }
        }
    }
}
