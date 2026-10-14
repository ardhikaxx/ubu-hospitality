<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Brand;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $query = Brand::query()->withCount('properties')->orderBy('sort_order');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        $brands = $query->paginate(10)->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(Request $request, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:brands,slug',
            'positioning_type' => 'required|string|in:standard,syariah,luxury,glamping',
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'story_id' => 'nullable|string',
            'story_en' => 'nullable|string',
            'accent_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'character_highlights_raw' => 'nullable|string',
            'cover_image_path' => 'nullable|string',
            'cover_image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'logo_path' => 'nullable|string',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = $imageService->processAndStore(
                $request->file('logo_file'),
                'brands',
                'brand_logo'
            );
        }
        unset($validated['logo_file']);

        if ($request->hasFile('cover_image_file')) {
            $validated['cover_image_path'] = $imageService->processAndStore(
                $request->file('cover_image_file'),
                'brands',
                'brand_cover'
            );
        }
        unset($validated['cover_image_file']);

        if (! empty($validated['character_highlights_raw'])) {
            $lines = array_filter(array_map('trim', explode("\n", $validated['character_highlights_raw'])));
            $validated['character_highlights_id'] = array_values($lines);
        }

        unset($validated['character_highlights_raw']);

        $brand = Brand::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'brand.created',
            'auditable_type' => Brand::class,
            'auditable_id' => $brand->id,
            'description' => "Menambahkan brand baru: {$brand->name}",
            'new_values' => $brand->toArray(),
        ]);

        return redirect()->route('admin.brands.index')->with('success', "Brand {$brand->name} berhasil ditambahkan.");
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand, ImageUploadService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:brands,slug,'.$brand->id,
            'positioning_type' => 'required|string|in:standard,syariah,luxury,glamping',
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'story_id' => 'nullable|string',
            'story_en' => 'nullable|string',
            'accent_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'character_highlights_raw' => 'nullable|string',
            'cover_image_path' => 'nullable|string',
            'cover_image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
            'logo_path' => 'nullable|string',
            'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        if ($request->hasFile('logo_file')) {
            $validated['logo_path'] = $imageService->replace(
                $request->file('logo_file'),
                $brand->logo_path,
                'brands',
                'brand_logo'
            );
        }
        unset($validated['logo_file']);

        if ($request->hasFile('cover_image_file')) {
            $validated['cover_image_path'] = $imageService->replace(
                $request->file('cover_image_file'),
                $brand->cover_image_path,
                'brands',
                'brand_cover'
            );
        }
        unset($validated['cover_image_file']);

        if (! empty($validated['character_highlights_raw'])) {
            $lines = array_filter(array_map('trim', explode("\n", $validated['character_highlights_raw'])));
            $validated['character_highlights_id'] = array_values($lines);
        }

        unset($validated['character_highlights_raw']);

        $oldValues = $brand->toArray();
        $brand->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'brand.updated',
            'auditable_type' => Brand::class,
            'auditable_id' => $brand->id,
            'description' => "Memperbarui data brand: {$brand->name}",
            'old_values' => $oldValues,
            'new_values' => $brand->toArray(),
        ]);

        return redirect()->route('admin.brands.index')->with('success', "Brand {$brand->name} berhasil diperbarui.");
    }

    public function destroy(Brand $brand, ImageUploadService $imageService): RedirectResponse
    {
        $name = $brand->name;
        $id = $brand->id;

        if ($brand->properties()->exists()) {
            return back()->with('error', "Brand {$name} tidak dapat dihapus karena masih menaungi properti aktif.");
        }

        if (! empty($brand->logo_path)) {
            $imageService->delete($brand->logo_path);
        }
        if (! empty($brand->cover_image_path)) {
            $imageService->delete($brand->cover_image_path);
        }

        $brand->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'brand.deleted',
            'auditable_type' => Brand::class,
            'auditable_id' => $id,
            'description' => "Menghapus brand: {$name}",
        ]);

        return redirect()->route('admin.brands.index')->with('success', "Brand {$name} berhasil dihapus.");
    }
}
