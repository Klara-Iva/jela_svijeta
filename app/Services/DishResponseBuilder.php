<?php

namespace App\Services;

class DishResponseBuilder
{
    public static function build($paginator, $dishes, $request)
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
                'prev' => $paginator->appends($request->query())->previousPageUrl(),
                'next' => $paginator->appends($request->query())->nextPageUrl(),
                'self' => $paginator->appends($request->query())->url($paginator->currentPage()),
            ],
        ]);
    }
}
