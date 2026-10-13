<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getAltTextAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->alt_text_en) ? $this->alt_text_en : ($this->alt_text_id ?: $this->original_name);
    }
}
