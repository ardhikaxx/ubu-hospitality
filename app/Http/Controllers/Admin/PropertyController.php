<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\AuditLog;
use App\Models\Brand;
use App\Models\Destination;
use App\Models\Property;
use App\Models\PropertyType;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::query()->with(['brand', 'propertyType', 'destination'])->latest('id');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('sentec_property_id', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->paginate(10)->withQueryString();
        $brands = Brand::active()->ordered()->get();

        return view('admin.properties.index', compact('properties', 'brands'));
    }

    public function create(): View
    {
        $brands = Brand::active()->ordered()->get();
        $propertyTypes = PropertyType::active()->orderBy('sort_order')->get();
        $destinations = Destination::active()->orderBy('sort_order')->get();
        $amenities = Amenity::orderBy('sort_order')->get();

        return view('admin.properties.create', compact('brands', 'propertyTypes', 'destinations', 'amenities'));
    }

    public function store(Request $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:properties,slug',
            'brand_id' => 'required|exists:brands,id',
            'property_type_id' => 'required|exists:property_types,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
            'headline_id' => 'nullable|string|max:255',
            'headline_en' => 'nullable|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'nullable|string',
            'max_guests' => 'required|integer|min:1|max:50',
            'bedrooms' => 'required|integer|min:1|max:30',
            'bathrooms' => 'required|integer|min:1|max:30',
            'beds_description' => 'nullable|string|max:150',
            'area_sqm' => 'nullable|integer',
            'starting_price_display' => 'required|numeric|min:0',
            'has_private_pool' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_syariah' => 'nullable|boolean',
            'sentec_property_id' => 'nullable|string|max:100|unique:properties,sentec_property_id',
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images_raw' => 'nullable|string',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'file|mimes:jpeg,png,jpg,webp|max:5120',
            'house_rules_id' => 'nullable|string',
            'cancellation_policy_id' => 'nullable|string',
            'checkin_time' => 'nullable|string|max:10',
            'checkout_time' => 'nullable|string|max:10',
            'google_maps_url' => 'nullable|string',
            'status' => 'required|string|in:published,draft,archived',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['has_private_pool'] = $request->boolean('has_private_pool');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_syariah'] = $request->boolean('is_syariah');

        if ($request->hasFile('featured_image_file')) {
            $validated['featured_image'] = $imageService->processAndStore(
                $request->file('featured_image_file'),
                'properties',
                'property_main'
            );
        }
        unset($validated['featured_image_file']);

        $gallery = [];
        if (! empty($validated['gallery_images_raw'])) {
            $gallery = array_values(array_filter(array_map('trim', explode("\n", $validated['gallery_images_raw']))));
        }
        unset($validated['gallery_images_raw']);

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gallery[] = $imageService->processAndStore($gFile, 'properties', 'property_gallery');
            }
        }
        unset($validated['gallery_files']);

        $validated['gallery_images'] = $gallery;

        $amenityIds = $validated['amenities'] ?? [];
        unset($validated['amenities']);

        $property = Property::create($validated);
        $property->amenities()->sync($amenityIds);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'property.created',
            'auditable_type' => Property::class,
            'auditable_id' => $property->id,
            'description' => "Menambahkan properti: {$property->name} (SENTEC ID: {$property->sentec_property_id})",
            'new_values' => $property->toArray(),
        ]);

        return redirect()->route('admin.properties.index')->with('success', "Properti {$property->name} berhasil disimpan.");
    }

    public function edit(Property $property): View
    {
        $brands = Brand::active()->ordered()->get();
        $propertyTypes = PropertyType::active()->orderBy('sort_order')->get();
        $destinations = Destination::active()->orderBy('sort_order')->get();
        $amenities = Amenity::orderBy('sort_order')->get();
        $selectedAmenities = $property->amenities->pluck('id')->toArray();

        return view('admin.properties.edit', compact('property', 'brands', 'propertyTypes', 'destinations', 'amenities', 'selectedAmenities'));
    }

    public function update(Request $request, Property $property, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:properties,slug,'.$property->id,
            'brand_id' => 'required|exists:brands,id',
            'property_type_id' => 'required|exists:property_types,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
            'headline_id' => 'nullable|string|max:255',
            'headline_en' => 'nullable|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'nullable|string',
            'max_guests' => 'required|integer|min:1|max:50',
            'bedrooms' => 'required|integer|min:1|max:30',
            'bathrooms' => 'required|integer|min:1|max:30',
            'beds_description' => 'nullable|string|max:150',
            'area_sqm' => 'nullable|integer',
            'starting_price_display' => 'required|numeric|min:0',
            'has_private_pool' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_syariah' => 'nullable|boolean',
            'sentec_property_id' => 'nullable|string|max:100|unique:properties,sentec_property_id,'.$property->id,
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images_raw' => 'nullable|string',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'file|mimes:jpeg,png,jpg,webp|max:5120',
            'house_rules_id' => 'nullable|string',
            'cancellation_policy_id' => 'nullable|string',
            'checkin_time' => 'nullable|string|max:10',
            'checkout_time' => 'nullable|string|max:10',
            'google_maps_url' => 'nullable|string',
            'status' => 'required|string|in:published,draft,archived',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['has_private_pool'] = $request->boolean('has_private_pool');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_syariah'] = $request->boolean('is_syariah');

        if ($request->hasFile('featured_image_file')) {
            $validated['featured_image'] = $imageService->replace(
                $request->file('featured_image_file'),
                $property->featured_image,
                'properties',
                'property_main'
            );
        }
        unset($validated['featured_image_file']);

        $gallery = [];
        if (! empty($validated['gallery_images_raw'])) {
            $gallery = array_values(array_filter(array_map('trim', explode("\n", $validated['gallery_images_raw']))));
        } elseif (is_array($property->gallery_images)) {
            $gallery = $property->gallery_images;
        }
        unset($validated['gallery_images_raw']);

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gallery[] = $imageService->processAndStore($gFile, 'properties', 'property_gallery');
            }
        }
        unset($validated['gallery_files']);

        $validated['gallery_images'] = $gallery;

        $amenityIds = $validated['amenities'] ?? [];
        unset($validated['amenities']);

        $oldValues = $property->toArray();
        $property->update($validated);
        $property->amenities()->sync($amenityIds);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'property.updated',
            'auditable_type' => Property::class,
            'auditable_id' => $property->id,
            'description' => "Memperbarui data properti: {$property->name}",
            'old_values' => $oldValues,
            'new_values' => $property->toArray(),
        ]);

        return redirect()->route('admin.properties.index')->with('success', "Properti {$property->name} berhasil diperbarui.");
    }

    public function destroy(Property $property, ImageUploadService $imageService): RedirectResponse
    {
        $name = $property->name;
        $id = $property->id;

        if (! empty($property->featured_image)) {
            $imageService->delete($property->featured_image);
        }

        if (is_array($property->gallery_images)) {
            foreach ($property->gallery_images as $gImg) {
                $imageService->delete($gImg);
            }
        }

        $property->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'property.deleted',
            'auditable_type' => Property::class,
            'auditable_id' => $id,
            'description' => "Menghapus properti: {$name}",
        ]);

        return redirect()->route('admin.properties.index')->with('success', "Properti {$name} berhasil dihapus.");
    }
}
