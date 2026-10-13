<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Brand;
use App\Models\Destination;
use App\Models\Property;
use App\Models\PropertyType;
use App\Services\Reviews\GoogleReviewsService;
use App\Services\Sentec\SentecServiceInterface;
use App\Services\Seo\SeoService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only([
            'brand',
            'property_type',
            'city',
            'guests',
            'bedrooms',
            'private_pool',
            'syariah',
            'min_price',
            'max_price',
            'amenities',
            'keyword',
            'sort',
        ]);

        $properties = Property::published()
            ->with(['brand', 'propertyType', 'destination', 'amenities'])
            ->withFilters($filters)
            ->paginate(9)
            ->withQueryString();

        $brands = Brand::active()->ordered()->get();
        $propertyTypes = PropertyType::active()->orderBy('sort_order')->get();
        $destinations = Destination::active()->orderBy('sort_order')->get();
        $amenities = Amenity::orderBy('sort_order')->get();

        $seoOverride = [
            'title' => 'Koleksi Villa & Glamping - Ubu Hospitality',
            'description' => 'Cari dan pesan private pool villa serta akomodasi syariah terbaik di Yogyakarta dengan jaminan ketersediaan resmi.',
        ];

        return view('properties.index', compact(
            'properties',
            'brands',
            'propertyTypes',
            'destinations',
            'amenities',
            'filters',
            'seoOverride'
        ));
    }

    public function show(string $slug, SentecServiceInterface $sentecService, GoogleReviewsService $reviewsService, SeoService $seoService): View
    {
        $property = Property::where('slug', $slug)
            ->published()
            ->with(['brand', 'propertyType', 'destination', 'amenities', 'units', 'promotions'])
            ->firstOrFail();

        $checkIn = request('check_in', Carbon::tomorrow()->toDateString());
        $checkOut = request('check_out', Carbon::tomorrow()->addDay()->toDateString());
        $guests = (int) request('guests', 2);
        $rooms = (int) request('rooms', 1);

        // Check availability via SENTEC (Single Source of Truth)
        $availability = null;
        if ($property->sentec_property_id) {
            $availability = $sentecService->checkAvailability(
                $property->sentec_property_id,
                $checkIn,
                $checkOut,
                $guests,
                $rooms
            );
        }

        $bookingUrl = $sentecService->generateBookingUrl($property, [
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => $guests,
            'rooms' => $rooms,
            'promo_code' => request('promo_code'),
        ]);

        $relatedProperties = Property::published()
            ->where('id', '!=', $property->id)
            ->where(function ($q) use ($property) {
                $q->where('brand_id', $property->brand_id)
                    ->orWhere('destination_id', $property->destination_id);
            })
            ->take(3)
            ->get();

        $reviews = $reviewsService->getFeaturedFiveStarReviews(propertyId: $property->id, limit: 3);

        $seoOverride = [
            'title' => $property->meta_title ?: "{$property->name} - {$property->city}",
            'description' => $property->meta_description ?: $property->headline,
            'image' => $property->featured_image,
        ];

        return view('properties.show', compact(
            'property',
            'availability',
            'bookingUrl',
            'relatedProperties',
            'reviews',
            'checkIn',
            'checkOut',
            'guests',
            'rooms',
            'seoOverride'
        ));
    }

    public function book(string $slug, SentecServiceInterface $sentecService): RedirectResponse
    {
        $property = Property::where('slug', $slug)->published()->firstOrFail();

        $url = $sentecService->generateBookingUrl($property, request()->all());

        return redirect()->away($url);
    }

    public function checkAvailabilityApi(string $slug, Request $request, SentecServiceInterface $sentecService): JsonResponse
    {
        $property = Property::where('slug', $slug)->published()->firstOrFail();

        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'nullable|integer|min:1|max:30',
            'rooms' => 'nullable|integer|min:1|max:10',
        ]);

        if (! $property->sentec_property_id) {
            return response()->json([
                'available' => false,
                'message' => 'Properti ini belum ditautkan dengan kode SENTEC.',
                'is_mock' => false,
            ], 422);
        }

        $result = $sentecService->checkAvailability(
            $property->sentec_property_id,
            $validated['check_in'],
            $validated['check_out'],
            (int) ($validated['guests'] ?? 2),
            (int) ($validated['rooms'] ?? 1)
        );

        $result['booking_url'] = $sentecService->generateBookingUrl($property, $validated);

        return response()->json($result);
    }
}
