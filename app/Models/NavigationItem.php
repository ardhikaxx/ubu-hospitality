<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class NavigationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title_id',
        'title_en',
        'url',
        'route_name',
        'target',
        'badge_text',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(NavigationMenu::class, 'menu_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'en' && ! empty($this->title_en) ? $this->title_en : $this->title_id;
    }

    public function getEffectiveUrlAttribute(): string
    {
        if (! empty($this->route_name) && Route::has($this->route_name)) {
            return route($this->route_name);
        }

        return $this->url;
    }
}
