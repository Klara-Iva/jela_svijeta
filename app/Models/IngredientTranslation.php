<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientTranslation extends Model
{
    protected $fillable = ['ingredient_id', 'locale', 'title'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
