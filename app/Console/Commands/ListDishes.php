<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dish;

class ListDishes extends Command
{
    protected $signature = 'dishes:list';
    protected $description = 'List all dishes from the database, including deleted ones';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dishes = Dish::withTrashed()->get();

        foreach ($dishes as $dish) {
            $this->info('ID: '.$dish->id);
            $this->info('Title: ' . $dish->title);
            $this->info('Status: ' . $dish->status);
            $this->info('Deleted At: ' . $dish->deleted_at); 
            $this->info('---'); // Separator
        }
    }
}
