<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;

class DishRequestValidator
{
    public static function validate(Request $request)
    {
        $validated = $request->validate([
            'lang' => 'required|string|size:2',
            'per_page' => 'sometimes|nullable|integer|min:1',
            'page' => 'sometimes|nullable|integer|min:1',
            'category' => [
                'sometimes',
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, ['NULL', '!NULL']) && !ctype_digit($value)) {
                        abort(400, 'The category field must be NULL, !NULL, or a valid integer.');
                    }
                }
            ]
            ,
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
}
