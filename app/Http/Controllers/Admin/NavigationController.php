<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Services\Navigation\NavigationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavigationController extends Controller
{
    public function index(NavigationService $navService): View
    {
        $menus = NavigationMenu::with('allItems')->get();

        return view('admin.navigations.index', compact('menus'));
    }

    public function store(Request $request, NavigationService $navService): RedirectResponse
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:navigation_menus,id',
            'title_id' => 'required|string|max:100',
            'title_en' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'target' => 'required|string|in:_self,_blank',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        NavigationItem::create($validated);
        $navService->clearCache();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'navigation.created',
            'description' => "Menambahkan item menu navigasi: {$validated['title_id']}",
        ]);

        return back()->with('success', 'Menu navigasi berhasil ditambahkan.');
    }

    public function update(Request $request, NavigationItem $navigation, NavigationService $navService): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:100',
            'title_en' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'target' => 'required|string|in:_self,_blank',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $navigation->update($validated);
        $navService->clearCache();

        return back()->with('success', 'Menu navigasi berhasil diperbarui.');
    }

    public function destroy(NavigationItem $navigation, NavigationService $navService): RedirectResponse
    {
        $navigation->delete();
        $navService->clearCache();

        return back()->with('success', 'Menu navigasi berhasil dihapus.');
    }
}
