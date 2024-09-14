<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Faker::class, function ($app) {
            return FakerFactory::create();
        });
    }

    public function boot(): void
    {
        //
    }
}


