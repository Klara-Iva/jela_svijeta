<?php

namespace App\Services;

class DishRelatedItemsBuilder
{
    public static function build($paginator, $lang, $with)
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
}
