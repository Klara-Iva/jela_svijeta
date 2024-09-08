<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishTranslation extends Model
{
    protected $fillable = ['dish_id', 'locale', 'title', 'description'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
