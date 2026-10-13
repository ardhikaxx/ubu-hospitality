<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\GuestReview;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = GuestReview::with(['property', 'brand'])->latest('review_date')->paginate(15);
        $properties = Property::published()->orderBy('name')->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.reviews.index', compact('reviews', 'properties', 'brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:100',
            'guest_origin' => 'nullable|string|max:100',
            'property_id' => 'nullable|exists:properties,id',
            'brand_id' => 'nullable|exists:brands,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text_id' => 'required|string',
            'review_text_en' => 'nullable|string',
            'review_date' => 'required|date',
            'source' => 'required|string|in:google,sentec,direct',
            'is_verified' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|string|in:published,hidden',
        ]);

        $validated['is_verified'] = $request->boolean('is_verified', true);
        $validated['is_featured'] = $request->boolean('is_featured', true);

        GuestReview::create($validated);

        return back()->with('success', 'Ulasan tamu berhasil ditambahkan.');
    }

    public function update(Request $request, GuestReview $review): RedirectResponse
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:100',
            'guest_origin' => 'nullable|string|max:100',
            'property_id' => 'nullable|exists:properties,id',
            'brand_id' => 'nullable|exists:brands,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text_id' => 'required|string',
            'review_text_en' => 'nullable|string',
            'review_date' => 'required|date',
            'source' => 'required|string|in:google,sentec,direct',
            'is_verified' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|string|in:published,hidden',
        ]);

        $validated['is_verified'] = $request->boolean('is_verified');
        $validated['is_featured'] = $request->boolean('is_featured');

        $review->update($validated);

        return back()->with('success', 'Ulasan tamu berhasil diperbarui.');
    }

    public function destroy(GuestReview $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Ulasan tamu berhasil dihapus.');
    }
}
