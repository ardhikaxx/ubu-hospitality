<?php

namespace App\Services\Navigation;

use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Throwable;

class NavigationService
{
    /**
     * Get menu items by location (cached with defensive integrity check).
     *
     * @return Collection<int, mixed>
     */
    public function getMenu(string $location): Collection
    {
        // Ensure NavigationItem class definition is loaded before any unserialization
        class_exists(NavigationItem::class);

        $cacheKey = "nav_menu_{$location}";

        try {
            $cached = Cache::get($cacheKey);

            if ($cached instanceof Collection) {
                $first = $cached->first();
                // If collection contains valid items or is empty, return it
                if ($first === null || (! ($first instanceof \__PHP_Incomplete_Class))) {
                    return $cached;
                }
            }
        } catch (Throwable) {
            // Silently fall through to clear cache and reload fresh from database
        }

        // Cache was missing, corrupt, or returned an incomplete serialized class
        Cache::forget($cacheKey);

        $menu = NavigationMenu::where('location', $location)->first();
        if (! $menu) {
            $items = collect();
        } else {
            $items = $menu->activeItems;
        }

        try {
            Cache::put($cacheKey, $items, 3600);
        } catch (Throwable) {
            // Silently continue if caching fails
        }

        return $items;
    }

    /**
     * Clear all navigation caches.
     */
    public function clearCache(): void
    {
        $locations = [
            'header_main',
            'footer_stay',
            'footer_company',
            'footer_partnership',
            'footer_help',
            'footer_legal',
        ];

        foreach ($locations as $loc) {
            Cache::forget("nav_menu_{$loc}");
        }
    }
}
