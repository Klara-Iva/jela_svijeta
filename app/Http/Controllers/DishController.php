<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en'); 

        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);
        $categoryId = $request->query('category');
        $tags = $request->query('tags', []);
        $with = explode(',', $request->query('with', ''));

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


        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $dishes = $paginator->map(function ($dish) use ($lang, $with) {
            return [
                'id' => $dish->id,
                'title' => $dish->translate($lang)->title ?? 'N/A',
                'description' => $dish->translate($lang)->description ?? 'N/A',
                'status' => $dish->status,
                'category' => in_array('category', $with) && $dish->category ? [
                    'id' => $dish->category->id,
                    'title' => $dish->category->translate($lang)->title ?? 'N/A',
                    'slug' => $dish->category->slug,
                ] : null,
                'tags' => in_array('tags', $with) ? $dish->tags->map(function ($tag) use ($lang) {
                    return [
                        'id' => $tag->id,
                        'title' => $tag->translate($lang)->title ?? 'N/A',
                        'slug' => $tag->slug,
                    ];
                }) : [],
                'ingredients' => in_array('ingredients', $with) ? $dish->ingredients->map(function ($ingredient) use ($lang) {
                    return [
                        'id' => $ingredient->id,
                        'title' => $ingredient->translate($lang)->title ?? 'N/A',
                        'slug' => $ingredient->slug,
                    ];
                }) : [],
            ];
        });

        return response()->json([
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'totalItems' => $paginator->total(),
                'itemsPerPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ],
            'data' => $dishes,
        ]);
    }
}
