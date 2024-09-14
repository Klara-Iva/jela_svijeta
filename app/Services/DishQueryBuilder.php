<?php

namespace App\Services;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Builder;

class DishQueryBuilder
{
    public static function build(array $validated)
    {
        $categoryId = $validated['categoryId'];
        $tags = $validated['tags'];
        $with = $validated['with'];
        $diffTime = $validated['diffTime'];
        $perPage = $validated['perPage'];
        $page = $validated['page'];

        $query = Dish::withTrashed();

        if ($categoryId === 'NULL') {
            $query->whereNull('category_id');
        } elseif ($categoryId === '!NULL') {
            $query->whereNotNull('category_id');
        } elseif (is_numeric($categoryId)) {
            $query->where('category_id', (int)$categoryId);
        }

        if (!empty($tags)) {
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tags.id', $tags);
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
}
