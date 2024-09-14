<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = ['slug'];
    public $translatedAttributes = ['title'];

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }


}

