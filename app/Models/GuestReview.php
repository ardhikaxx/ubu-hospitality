<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'brand_id',
        'guest_name',
        'guest_origin',
        'rating',
        'review_text_id',
        'review_text_en',
        'review_date',
        'source',
        'google_review_id',
        'avatar_url',
        'is_verified',
        'is_featured',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'review_date' => 'date',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFiveStar(Builder $query): Builder
    {
        return $query->where('rating', 5);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getReviewTextAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->review_text_en) ? $this->review_text_en : $this->review_text_id;
    }
}
