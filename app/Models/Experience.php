<?php

namespace App\Models;

use App\Support\ImageFallback;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_id',
        'title_en',
        'slug',
        'category',
        'short_description_id',
        'short_description_en',
        'content_id',
        'content_en',
        'featured_image',
        'gallery_images',
        'price_display',
        'location',
        'brand_id',
        'property_id',
        'sort_order',
        'status',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en',
    ];

    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id', 'desc');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->short_description_en) ? $this->short_description_en : $this->short_description_id;
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->content_en) ? $this->content_en : $this->content_id;
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return ImageFallback::url($this->featured_image);
    }
}
