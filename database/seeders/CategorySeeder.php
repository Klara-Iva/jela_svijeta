<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Helpers\SeederHelper;

class CategorySeeder extends Seeder
{
    protected $faker;


    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    { 
        SeederHelper::createWithTranslations(
        Category::class,
        'userName',
        $this->faker
        );
    }
}
