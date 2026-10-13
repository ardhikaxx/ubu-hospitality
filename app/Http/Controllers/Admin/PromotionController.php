<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Brand;
use App\Models\Promotion;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Promotion::query()->with(['brands', 'properties'])->orderBy('priority', 'desc');

        if ($request->filled('q')) {
            $query->where('code', 'like', '%'.$request->q.'%')
                ->orWhere('title_id', 'like', '%'.$request->q.'%');
        }

        $promotions = $query->paginate(10)->withQueryString();

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create(): View
    {
        $brands = Brand::active()->ordered()->get();
        $properties = Property::published()->orderBy('name')->get();

        return view('admin.promotions.create', compact('brands', 'properties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'title_id' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'subtitle_id' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:1',
            'booking_period_start' => 'required|date',
            'booking_period_end' => 'required|date|after_or_equal:booking_period_start',
            'stay_period_start' => 'required|date',
            'stay_period_end' => 'required|date|after_or_equal:stay_period_start',
            'banner_image' => 'nullable|string',
            'terms_conditions_id' => 'nullable|string',
            'terms_conditions_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'is_new_user_only' => 'nullable|boolean',
            'is_popup' => 'nullable|boolean',
            'priority' => 'nullable|integer',
            'status' => 'required|string|in:published,draft,expired',
            'brand_ids' => 'nullable|array',
            'property_ids' => 'nullable|array',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['slug'] = Str::slug($validated['code'].'-'.$validated['title_id']);
        $validated['is_new_user_only'] = $request->boolean('is_new_user_only');
        $validated['is_popup'] = $request->boolean('is_popup');
        $validated['priority'] = (int) ($validated['priority'] ?? 0);

        $brandIds = $validated['brand_ids'] ?? [];
        $propertyIds = $validated['property_ids'] ?? [];
        unset($validated['brand_ids'], $validated['property_ids']);

        $promotion = Promotion::create($validated);
        $promotion->brands()->sync($brandIds);
        $promotion->properties()->sync($propertyIds);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'promotion.created',
            'auditable_type' => Promotion::class,
            'auditable_id' => $promotion->id,
            'description' => "Menambahkan promo: {$promotion->code} - {$promotion->title_id}",
            'new_values' => $promotion->toArray(),
        ]);

        return redirect()->route('admin.promotions.index')->with('success', "Promo {$promotion->code} berhasil dibuat.");
    }

    public function edit(Promotion $promotion): View
    {
        $brands = Brand::active()->ordered()->get();
        $properties = Property::published()->orderBy('name')->get();
        $selectedBrands = $promotion->brands->pluck('id')->toArray();
        $selectedProperties = $promotion->properties->pluck('id')->toArray();

        return view('admin.promotions.edit', compact('promotion', 'brands', 'properties', 'selectedBrands', 'selectedProperties'));
    }

    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,'.$promotion->id,
            'title_id' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'subtitle_id' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:1',
            'booking_period_start' => 'required|date',
            'booking_period_end' => 'required|date|after_or_equal:booking_period_start',
            'stay_period_start' => 'required|date',
            'stay_period_end' => 'required|date|after_or_equal:stay_period_start',
            'banner_image' => 'nullable|string',
            'terms_conditions_id' => 'nullable|string',
            'terms_conditions_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'is_new_user_only' => 'nullable|boolean',
            'is_popup' => 'nullable|boolean',
            'priority' => 'nullable|integer',
            'status' => 'required|string|in:published,draft,expired',
            'brand_ids' => 'nullable|array',
            'property_ids' => 'nullable|array',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_new_user_only'] = $request->boolean('is_new_user_only');
        $validated['is_popup'] = $request->boolean('is_popup');
        $validated['priority'] = (int) ($validated['priority'] ?? 0);

        $brandIds = $validated['brand_ids'] ?? [];
        $propertyIds = $validated['property_ids'] ?? [];
        unset($validated['brand_ids'], $validated['property_ids']);

        $promotion->update($validated);
        $promotion->brands()->sync($brandIds);
        $promotion->properties()->sync($propertyIds);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'promotion.updated',
            'auditable_type' => Promotion::class,
            'auditable_id' => $promotion->id,
            'description' => "Memperbarui promo: {$promotion->code}",
        ]);

        return redirect()->route('admin.promotions.index')->with('success', "Promo {$promotion->code} berhasil diperbarui.");
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        $code = $promotion->code;
        $promotion->brands()->detach();
        $promotion->properties()->detach();
        $promotion->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'promotion.deleted',
            'auditable_type' => Promotion::class,
            'auditable_id' => $promotion->id,
            'description' => "Menghapus promo: {$code}",
        ]);

        return redirect()->route('admin.promotions.index')->with('success', "Promo {$code} berhasil dihapus.");
    }
}
