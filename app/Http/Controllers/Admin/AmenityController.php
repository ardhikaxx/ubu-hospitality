<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AmenityController extends Controller
{
    public function index(): View
    {
        $amenities = Amenity::withCount('properties')->orderBy('sort_order')->get();

        return view('admin.amenities.index', compact('amenities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'category' => 'required|string|in:general,room,outdoor,service,syariah',
            'icon' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        Amenity::create($validated);

        return back()->with('success', 'Fasilitas baru berhasil ditambahkan.');
    }

    public function update(Request $request, Amenity $amenity): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
            'category' => 'required|string|in:general,room,outdoor,service,syariah',
            'icon' => 'required|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $amenity->update($validated);

        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Amenity $amenity): RedirectResponse
    {
        $amenity->properties()->detach();
        $amenity->delete();

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}
