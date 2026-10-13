<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'author_id',
        'title_id',
        'title_en',
        'slug',
        'excerpt_id',
        'excerpt_en',
        'content_id',
        'content_en',
        'featured_image',
        'reading_time_minutes',
        'related_property_ids',
        'status',
        'published_at',
        'views_count',
        'meta_title_id',
        'meta_title_en',
        'meta_description_id',
        'meta_description_en',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'related_property_ids' => 'array',
            'published_at' => 'datetime',
            'reading_time_minutes' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', Carbon::now());
            });
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->excerpt_en) ? $this->excerpt_en : $this->excerpt_id;
    }

    public function getContentAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->content_en) ? $this->content_en : $this->content_id;
    }
}
