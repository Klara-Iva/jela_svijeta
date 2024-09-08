<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $fillable = ['tag_id', 'locale', 'title'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
