<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_url',
        'target_url',
        'status_code',
        'hits',
        'is_active',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'hits' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
