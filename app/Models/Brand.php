<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'is_master_brand',
        'tagline_id',
        'tagline_en',
        'description_id',
        'description_en',
        'story_id',
        'story_en',
        'positioning_type',
        'character_highlights_id',
        'character_highlights_en',
        'logo_path',
        'cover_image_path',
        'gallery_images',
        'accent_color',
        'secondary_color',
        'sort_order',
        'is_active',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'is_master_brand' => 'boolean',
            'is_active' => 'boolean',
            'character_highlights_id' => 'array',
            'character_highlights_en' => 'array',
            'gallery_images' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'promotion_brand');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(GuestReview::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getTaglineAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->tagline_en) ? $this->tagline_en : $this->tagline_id;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->description_en) ? $this->description_en : $this->description_id;
    }

    public function getStoryAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->story_en) ? $this->story_en : $this->story_id;
    }

    public function getCharacterHighlightsAttribute(): array
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && ! empty($this->character_highlights_en)) {
            return $this->character_highlights_en;
        }

        return $this->character_highlights_id ?? [];
    }

    public function getMetaTitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->meta_title_en) ? $this->meta_title_en : ($this->meta_title_id ?: $this->name);
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->meta_description_en) ? $this->meta_description_en : ($this->meta_description_id ?: $this->description);
    }
}
