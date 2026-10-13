<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::query()->with(['category', 'author'])->latest('id');

        if ($request->filled('q')) {
            $query->where('title_id', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = BlogCategory::all();

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = BlogCategory::all();

        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title_id' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:blog_posts,slug',
            'excerpt_id' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'content_id' => 'required|string',
            'content_en' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'reading_time_minutes' => 'nullable|integer',
            'status' => 'required|string|in:published,draft,scheduled',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title_id']);
        $validated['author_id'] = auth()->id();
        $validated['reading_time_minutes'] = (int) ($validated['reading_time_minutes'] ?? 3);

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::now();
        }

        $post = BlogPost::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'blog.created',
            'auditable_type' => BlogPost::class,
            'auditable_id' => $post->id,
            'description' => "Membuat artikel blog: {$post->title_id}",
        ]);

        return redirect()->route('admin.blog.index')->with('success', "Artikel {$post->title_id} berhasil disimpan.");
    }

    public function edit(BlogPost $post): View
    {
        $categories = BlogCategory::all();

        return view('admin.blog.edit', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'title_id' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:blog_posts,slug,'.$post->id,
            'excerpt_id' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'content_id' => 'required|string',
            'content_en' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'reading_time_minutes' => 'nullable|integer',
            'status' => 'required|string|in:published,draft,scheduled',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['reading_time_minutes'] = (int) ($validated['reading_time_minutes'] ?? 3);

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::now();
        }

        $post->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'blog.updated',
            'auditable_type' => BlogPost::class,
            'auditable_id' => $post->id,
            'description' => "Memperbarui artikel blog: {$post->title_id}",
        ]);

        return redirect()->route('admin.blog.index')->with('success', "Artikel {$post->title_id} berhasil diperbarui.");
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $title = $post->title_id;
        $post->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'blog.deleted',
            'auditable_type' => BlogPost::class,
            'auditable_id' => $post->id,
            'description' => "Menghapus artikel blog: {$title}",
        ]);

        return redirect()->route('admin.blog.index')->with('success', "Artikel {$title} berhasil dihapus.");
    }
}
