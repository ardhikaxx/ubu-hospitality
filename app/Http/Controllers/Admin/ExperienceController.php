<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Brand;
use App\Models\Experience;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::with(['brand', 'property'])->ordered()->paginate(10);

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create(): View
    {
        $brands = Brand::active()->ordered()->get();
        $properties = Property::published()->orderBy('name')->get();

        return view('admin.experiences.create', compact('brands', 'properties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:experiences,slug',
            'category' => 'required|string|in:wellness,culinary,adventure,family,culture,meeting',
            'short_description_id' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'content_id' => 'nullable|string',
            'content_en' => 'nullable|string',
            'price_display' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'featured_image' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'property_id' => 'nullable|exists:properties,id',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:published,draft',
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title_id']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $experience = Experience::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'experience.created',
            'auditable_type' => Experience::class,
            'auditable_id' => $experience->id,
            'description' => "Menambahkan aktivitas/experience: {$experience->title_id}",
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience berhasil ditambahkan.');
    }

    public function edit(Experience $experience): View
    {
        $brands = Brand::active()->ordered()->get();
        $properties = Property::published()->orderBy('name')->get();

        return view('admin.experiences.edit', compact('experience', 'brands', 'properties'));
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:experiences,slug,'.$experience->id,
            'category' => 'required|string|in:wellness,culinary,adventure,family,culture,meeting',
            'short_description_id' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'content_id' => 'nullable|string',
            'content_en' => 'nullable|string',
            'price_display' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'featured_image' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'property_id' => 'nullable|exists:properties,id',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:published,draft',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $experience->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'experience.updated',
            'auditable_type' => Experience::class,
            'auditable_id' => $experience->id,
            'description' => "Memperbarui experience: {$experience->title_id}",
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience berhasil diperbarui.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $title = $experience->title_id;
        $experience->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'experience.deleted',
            'auditable_type' => Experience::class,
            'auditable_id' => $experience->id,
            'description' => "Menghapus experience: {$title}",
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience berhasil dihapus.');
    }
}
