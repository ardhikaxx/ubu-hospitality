<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'status',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en',
        'meta_keywords',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function activeSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->subtitle_en) ? $this->subtitle_en : $this->subtitle_id;
    }
}
