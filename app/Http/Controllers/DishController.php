<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;

class DishController extends Controller
{
    public function index(Request $request)
    {   
        //lang is a required parameter in URL
        $validatedLanguage = $request->validate([
            'lang' => 'required|string|size:2', 
        ]);

        $lang = $validatedLanguage['lang']; //converts array into string

        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);
        $categoryId = $request->query('category');
        $tags = $request->query('tags', []);
        $with = explode(',', $request->query('with', ''));
        $diffTime = $request->query('diff_time');

        $query = Dish::query();

        if ($categoryId === 'NULL') {
            $query->whereNull('category_id');
        } elseif ($categoryId === '!NULL') {
            $query->whereNotNull('category_id');
        } elseif ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($tags)) {
            $tagIds = explode(',', $tags);
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds); 
            });
        }

        if (in_array('category', $with)) {
            $query->with('category.translations');
        }
        if (in_array('tags', $with)) {
            $query->with('tags.translations');
        }
        if (in_array('ingredients', $with)) {
            $query->with('ingredients.translations');
        }

        if ($diffTime) {
            $diffTimestamp = (int)$diffTime;
            $diffDateTime = date('Y-m-d H:i:s', $diffTimestamp);

            $query->where(function (Builder $q) use ($diffDateTime) {
                $q->where(function (Builder $q) use ($diffDateTime) {
                    $q->whereNotNull('deleted_at')
                      ->where('deleted_at', '>', $diffDateTime);
                })->orWhere(function (Builder $q) use ($diffDateTime) {
                    $q->whereNotNull('updated_at')
                      ->where('updated_at', '>', $diffDateTime);
                })->orWhere(function (Builder $q) use ($diffDateTime) {
                    $q->where('created_at', '>', $diffDateTime);
                });
            });
        } else {
            $query->where('status', 'created');
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $dishes = $paginator->map(function ($dish) use ($lang, $with, $diffTime) {
      
      

            $result = [
                'id' => $dish->id,
                'title' => $dish->translate($lang)->title ?? 'N/A',
                'description' => $dish->translate($lang)->description ?? 'N/A',
                'status' => $dish->status,
            ];

            if (in_array('category', $with) && $dish->category) {
                $result['category'] = [
                    'id' => $dish->category->id,
                    'title' => $dish->category->translate($lang)->title ?? 'N/A',
                    'slug' => $dish->category->slug,
                ];
            }
        
            if (in_array('tags', $with)) {
                $result['tags'] = $dish->tags->map(function ($tag) use ($lang) {
                    return [
                        'id' => $tag->id,
                        'title' => $tag->translate($lang)->title ?? 'N/A',
                        'slug' => $tag->slug,
                    ];
                });
            } 
        
            if (in_array('ingredients', $with)) {
                $result['ingredients'] = $dish->ingredients->map(function ($ingredient) use ($lang) {
                    return [
                        'id' => $ingredient->id,
                        'title' => $ingredient->translate($lang)->title ?? 'N/A',
                        'slug' => $ingredient->slug,
                     
                    ];
                });
            } 

            return $result;
        });

        return response()->json([
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'totalItems' => $paginator->total(),
                'itemsPerPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ],


            'data' => $dishes,

            'links'=>[
                'prev' => $paginator->appends($request->query())->previousPageUrl(),//$paginator->previousPageUrl() doesnt include all written options in URL  by default
                'next' => $paginator->appends($request->query())->nextPageUrl(),
                'self' => $paginator->appends($request->query())->url($paginator->currentPage()), 
            ],
        ]);
    }
}
