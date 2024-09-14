<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use Illuminate\Http\Request;
use App\Models\Dish;

use Illuminate\Database\Eloquent\Builder;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $validated = $this->validateRequest($request);

        $paginator = $this->buildDishQuery($validated);

        $dishes = $this->ObradiWith($paginator, $validated['lang'], $validated['with']);

        $data = $this->makeJSON($paginator, $dishes, $request);

        return $data;

    }

    public function validateRequest(Request $request)
    {

        $validated = $request->validate([
            'lang' => 'required|string|size:2',
            'per_page' => 'sometimes|nullable|integer|min:1',
            'page' => 'sometimes|nullable|integer|min:1',
            'category' => 'sometimes|nullable|in:NULL,!NULL,integer',
            'tags' => 'sometimes|nullable|string',
            'with' => 'sometimes|nullable|string',
            'diff_time' => 'sometimes|nullable|integer|min:1',
        ]);

        return [
            'lang' => $validated['lang'],
            'perPage' => $validated['per_page'] ?? 30,
            'page' => $validated['page'] ?? 1,
            'categoryId' => $validated['category'] ?? null,
            'tags' => isset($validated['tags']) ? explode(',', $validated['tags']) : [],
            'with' => isset($validated['with']) ? explode(',', $validated['with']) : [],
            'diffTime' => $validated['diff_time'] ?? null
        ];

    }
    public function buildDishQuery($validated)
    {

        $categoryId = $validated['categoryId'];
        $tags = $validated['tags'];
        $with = $validated['with'];
        $diffTime = $validated['diffTime'];
        $perPage = $validated['perPage'];
        $page = $validated['page'];

        $query = Dish::withTrashed(); //bc of Soft Deletes->deleted dishes not showing if not included this way

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
            $diffTimestamp = (int) $diffTime;
            $diffDateTime = date('Y-m-d H:i:s', $diffTimestamp);

            $query->where(function (Builder $q) use ($diffDateTime) {
                $q->where(function (Builder $q) use ($diffDateTime) {
                    $q->whereNotNull('deleted_at')
                        ->where('deleted_at', '>', $diffDateTime)
                        ->where('status', 'deleted');
                })->orWhere(function (Builder $q) use ($diffDateTime) {
                    $q->whereNotNull('updated_at')
                        ->where('updated_at', '>', $diffDateTime)
                        ->where('status', 'modified');
                })->orWhere(function (Builder $q) use ($diffDateTime) {
                    $q->where('created_at', '>', $diffDateTime)
                        ->where('status', 'created');
                });
            });
        } else {
            $query->where('status', 'created');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }


    public function ObradiWith($paginator, $lang, $with)
    {

        return $paginator->map(function ($dish) use ($lang, $with) {
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

    }


    private function makeJSON($paginator, $dishes, $request)
    {
        return response()->json([
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'totalItems' => $paginator->total(),
                'itemsPerPage' => $paginator->perPage(),
                'totalPages' => $paginator->lastPage(),
            ],


            'data' => $dishes,

            'links' => [
                'prev' => $paginator->appends($request->query())->previousPageUrl(),//$paginator->previousPageUrl() doesnt include all written options in URL  by default
                'next' => $paginator->appends($request->query())->nextPageUrl(),
                'self' => $paginator->appends($request->query())->url($paginator->currentPage()),
            ],
        ]);
    }

}
