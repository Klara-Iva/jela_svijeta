<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function showTags()
    {
        $tags = DB::table('tags')->get();
     
        
        return view('tags', ['tags' => $tags]);
    }

    public function showIngredients()
    {
        $ingredients = DB::table('ingredients')->get();
   
        
        return view('ingredients', ['ingredients' => $ingredients]);
    }

    public function showCategories()
    {
        $categories = DB::table('categories')->get();
        return view('categories', ['categories' => $categories]);
    }
}
