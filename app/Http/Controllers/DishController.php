<?php

namespace App\Http\Controllers;

 

use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
     
    public function showDishes(Request $request)
    {
        $locale = $request->query('lang', 'en'); 
        app()->setLocale($locale);

        $dishes = Dish::with(['translations', 'category.translations', 'tags.translations', 'ingredients.translations'])
                      ->get();

        return view('dishes', [
            'dishes' => $dishes,
            'currentLocale' => $locale,
        ]);
    }
    
}
