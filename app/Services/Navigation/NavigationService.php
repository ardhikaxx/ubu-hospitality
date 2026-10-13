<?php

namespace App\Services\Navigation;

use App\Models\NavigationMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    /**
     * Get menu items by location (cached).
     *
     * @return Collection<int, mixed>
     */
    public function getMenu(string $location): Collection
    {
        return Cache::remember("nav_menu_{$location}", 3600, function () use ($location) {
            $menu = NavigationMenu::where('location', $location)->first();
            if (! $menu) {
                return collect();
            }

            return $menu->activeItems;
        });
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
