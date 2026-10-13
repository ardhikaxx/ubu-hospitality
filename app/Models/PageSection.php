<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'section_key',
        'title_id',
        'title_en',
        'subtitle_id',
        'subtitle_en',
        'content_id',
        'content_en',
        'media_path',
        'extra_data',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->subtitle_en) ? $this->subtitle_en : $this->subtitle_id;
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->content_en) ? $this->content_en : $this->content_id;
    }
}
