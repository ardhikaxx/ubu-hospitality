<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Property;
use App\Services\Reviews\GoogleReviewsService;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function show(string $slug, GoogleReviewsService $reviewsService): View
    {
        $brand = Brand::where('slug', $slug)
            ->active()
            ->withCount('properties')
            ->firstOrFail();

        $properties = Property::published()
            ->where('brand_id', $brand->id)
            ->with(['propertyType', 'destination', 'amenities'])
            ->orderBy('sort_order')
            ->paginate(6);

        $reviews = $reviewsService->getFeaturedFiveStarReviews(brandId: $brand->id, limit: 3);

        $seoOverride = [
            'title' => $brand->meta_title ?: "{$brand->name} - {$brand->tagline}",
            'description' => $brand->meta_description ?: $brand->description,
            'image' => $brand->cover_image_path,
        ];

        return view('brands.show', compact('brand', 'properties', 'reviews', 'seoOverride'));
    }
}
