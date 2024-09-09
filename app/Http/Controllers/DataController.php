<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function showTags(Request $request)
    {
        $locale = $request->input('lang', 'en'); 
        app()->setLocale($locale); 

      
        $tags = Tag::all();

        return view('tags', ['tags' => $tags]);
    }

    public function showIngredients(Request $request)
    {
        $locale = $request->input('lang', 'en');
        app()->setLocale($locale);

      
        $ingredients = Ingredient::all();

        return view('ingredients', ['ingredients' => $ingredients]);
    }

    public function showCategories(Request $request)
    {
        $locale = $request->input('lang', 'en');
        app()->setLocale($locale);
        $categories = Category::all();

        return view('categories', ['categories' => $categories]);
    }
}
