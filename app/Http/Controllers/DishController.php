<?php

namespace App\Http\Controllers;

use App\Http\Validators\DishRequestValidator;
use App\Services\DishQueryBuilder;
use App\Services\DishRelatedItemsBuilder;
use App\Services\DishResponseBuilder;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index(Request $request)
    {
        $validated = DishRequestValidator::validate($request);

        $paginator = DishQueryBuilder::build($validated);

        $dishes = DishRelatedItemsBuilder::build($paginator, $validated['lang'], $validated['with']);

        return DishResponseBuilder::build($paginator, $dishes, $request);
    }
}
