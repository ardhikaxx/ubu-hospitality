<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id',
        'name_en',
        'slug',
        'description_id',
        'description_en',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->name_en) ? $this->name_en : $this->name_id;
    }
}
