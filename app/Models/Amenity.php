<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_id',
        'name_en',
        'category',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_amenity');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name_id');
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->name_en) ? $this->name_en : $this->name_id;
    }
}
