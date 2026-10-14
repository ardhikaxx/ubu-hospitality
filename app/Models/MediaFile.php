<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'disk',
        'path',
        'mime_type',
        'file_size',
        'alt_text_id',
        'alt_text_en',
        'caption',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->path)) {
            return asset('images/default-img.png');
        }

        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        $cleanPath = ltrim(str_replace('storage/', '', $this->path), '/');
        if (! str_starts_with($cleanPath, 'uploads/')) {
            $cleanPath = 'uploads/media/'.$this->filename;
        }

        return asset($cleanPath);
    }

    public function getAltTextAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->alt_text_en) ? $this->alt_text_en : ($this->alt_text_id ?: $this->original_name);
    }
}
