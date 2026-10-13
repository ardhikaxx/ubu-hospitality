<?php

namespace App\Services\Reviews;

use App\Models\GuestReview;
use App\Models\Setting;
use Illuminate\Support\Collection;

class GoogleReviewsService
{
    /**
     * Get 5-star guest reviews for display on homepage or brand/property pages.
     *
     * @return Collection<int, GuestReview>
     */
    public function getFeaturedFiveStarReviews(?int $propertyId = null, ?int $brandId = null, int $limit = 6): Collection
    {
        $enabled = Setting::get('google_reviews_enabled', true);
        if (! $enabled) {
            return collect();
        }

        $query = GuestReview::query()
            ->published()
            ->fiveStar()
            ->where('is_featured', true);

        if ($propertyId) {
            $query->where('property_id', $propertyId);
        } elseif ($brandId) {
            $query->where('brand_id', $brandId);
        }

        return $query->latest('review_date')->take($limit)->get();
    }
}
