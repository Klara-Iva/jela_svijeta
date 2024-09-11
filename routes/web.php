<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;

Route::get('/dishes', [DishController::class, 'index']);