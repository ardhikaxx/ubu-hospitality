<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'description_id',
        'description_en',
        'capacity_guests',
        'bedrooms',
        'bathrooms',
        'beds_configuration',
        'area_sqm',
        'price_estimate',
        'sentec_room_type_id',
        'images',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_active' => 'boolean',
            'capacity_guests' => 'integer',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'area_sqm' => 'integer',
            'sort_order' => 'integer',
            'price_estimate' => 'decimal:2',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->description_en) ? $this->description_en : $this->description_id;
    }
}
