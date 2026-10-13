<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::withCount('sections')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page): View
    {
        $page->load('sections');

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:150',
            'title_en' => 'required|string|max:150',
            'subtitle_id' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'status' => 'required|string|in:published,draft',
            'meta_title_id' => 'nullable|string|max:200',
            'meta_description_id' => 'nullable|string',
        ]);

        $page->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'page.updated',
            'auditable_type' => Page::class,
            'auditable_id' => $page->id,
            'description' => "Memperbarui halaman: {$page->slug}",
        ]);

        return back()->with('success', 'Informasi halaman berhasil diperbarui.');
    }

    public function updateSection(Request $request, PageSection $section): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => 'nullable|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'subtitle_id' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'content_id' => 'nullable|string',
            'content_en' => 'nullable|string',
            'media_path' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $section->update($validated);

        return back()->with('success', "Bagian konten '{$section->section_key}' berhasil diperbarui.");
    }
}
