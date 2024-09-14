<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
