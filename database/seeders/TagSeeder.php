<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\Helpers\SeederHelper;

class TagSeeder extends Seeder{
    protected $faker;


    public function __construct(Faker $faker){ $this->faker=$faker;}

    public function run()
    { 
        SeederHelper::createWithTranslations(
        Tag::class,
        'currencyCode',
        $this->faker
    );
}
}
