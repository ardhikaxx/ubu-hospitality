<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'name',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->orderBy('sort_order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order');
    }
}
