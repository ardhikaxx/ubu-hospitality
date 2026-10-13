<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Promotion;
use App\Models\Property;
use App\Services\Reviews\GoogleReviewsService;
use App\Services\Seo\SeoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(GoogleReviewsService $reviewsService, SeoService $seoService): View
    {
        $featuredProperties = Property::published()
            ->featured()
            ->with(['brand', 'propertyType'])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $brands = Brand::active()
            ->ordered()
            ->withCount('properties')
            ->get();

        $destinations = Destination::active()
            ->orderBy('sort_order')
            ->withCount('properties')
            ->get();

        $activePromos = Promotion::published()
            ->activeBooking()
            ->latest('priority')
            ->take(3)
            ->get();

        $experiences = Experience::published()
            ->ordered()
            ->take(3)
            ->get();

        $latestPosts = BlogPost::published()
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        $reviews = $reviewsService->getFeaturedFiveStarReviews(limit: 4);

        $seoOverride = [
            'title' => 'Ubu Hospitality - Private Luxury Villa & Glamping Management in Yogyakarta',
            'description' => 'Menaungi brand ternama Ubu Villa dan Buruj Villa (Syariah-compliant). Temukan private pool villa mewah dengan layanan hospitality berstandar bintang lima di Yogyakarta.',
        ];

        return view('home', compact(
            'featuredProperties',
            'brands',
            'destinations',
            'activePromos',
            'experiences',
            'latestPosts',
            'reviews',
            'seoOverride'
        ));
    }
}
