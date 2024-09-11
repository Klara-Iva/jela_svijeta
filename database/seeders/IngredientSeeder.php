<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\Helpers\SeederHelper;


class IngredientSeeder extends Seeder
{
    protected $faker;
   
    public function __construct(Faker $faker)
    {
        $this->faker=$faker;
    }


    public function run()
        { SeederHelper::createWithTranslations(
            Ingredient::class,
            'safeColorName',
            $this->faker
        );
    }
      
}
