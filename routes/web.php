<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DishController;

/*Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/dishes', [DishController::class, 'showDishes']);


Route::get('/tags', [DataController::class, 'showTags']);
Route::get('/ingredients', [DataController::class, 'showIngredients']);
Route::get('/categories', [DataController::class, 'showCategories']);
