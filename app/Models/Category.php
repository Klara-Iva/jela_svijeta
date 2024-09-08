<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['slug'];

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }


    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}
