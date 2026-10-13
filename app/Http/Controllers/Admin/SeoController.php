<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SeoRedirect;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $redirects = SeoRedirect::latest()->paginate(15);
        $settings = [
            'default_meta_title_id' => Setting::get('default_meta_title_id'),
            'default_meta_title_en' => Setting::get('default_meta_title_en'),
            'default_meta_description_id' => Setting::get('default_meta_description_id'),
            'default_meta_description_en' => Setting::get('default_meta_description_en'),
        ];

        return view('admin.seo.index', compact('redirects', 'settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_meta_title_id' => 'required|string|max:200',
            'default_meta_title_en' => 'required|string|max:200',
            'default_meta_description_id' => 'required|string|max:300',
            'default_meta_description_en' => 'required|string|max:300',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val, 'seo', 'text');
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'seo.settings_updated',
            'description' => 'Memperbarui konfigurasi default SEO metadata.',
        ]);

        return back()->with('success', 'Pengaturan SEO default berhasil diperbarui.');
    }

    public function storeRedirect(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_url' => 'required|string|max:500|unique:seo_redirects,source_url',
            'target_url' => 'required|string|max:500',
            'status_code' => 'required|integer|in:301,302',
            'note' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['source_url'] = '/'.ltrim($validated['source_url'], '/');
        $validated['is_active'] = $request->boolean('is_active', true);

        SeoRedirect::create($validated);

        return back()->with('success', 'Aturan pengalihan URL (Redirect) berhasil ditambahkan.');
    }

    public function updateRedirect(Request $request, SeoRedirect $redirect): RedirectResponse
    {
        $validated = $request->validate([
            'source_url' => 'required|string|max:500|unique:seo_redirects,source_url,'.$redirect->id,
            'target_url' => 'required|string|max:500',
            'status_code' => 'required|integer|in:301,302',
            'note' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['source_url'] = '/'.ltrim($validated['source_url'], '/');
        $validated['is_active'] = $request->boolean('is_active');

        $redirect->update($validated);

        return back()->with('success', 'Aturan pengalihan URL berhasil diperbarui.');
    }

    public function destroyRedirect(SeoRedirect $redirect): RedirectResponse
    {
        $redirect->delete();

        return back()->with('success', 'Aturan pengalihan URL berhasil dihapus.');
    }
}
