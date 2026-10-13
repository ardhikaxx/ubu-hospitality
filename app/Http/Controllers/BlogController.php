<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->get('category');
        $search = $request->get('q');

        $query = BlogPost::published()
            ->with(['category', 'author'])
            ->latest('published_at');

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_id', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%")
                    ->orWhere('content_id', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::withCount(['posts' => fn ($q) => $q->published()])->get();

        $seoOverride = [
            'title' => 'Inspirasi & Cerita Menginap - Ubu Hospitality Blog',
            'description' => 'Panduan wisata Yogyakarta, rekomendasi villa private pool, dan tips liburan keluarga syariah dari Ubu Hospitality.',
        ];

        return view('blog.index', compact('posts', 'categories', 'categorySlug', 'search', 'seoOverride'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['category', 'author'])
            ->firstOrFail();

        $post->increment('views_count');

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $relatedProperties = collect();
        if (! empty($post->related_property_ids)) {
            $relatedProperties = Property::published()
                ->whereIn('id', $post->related_property_ids)
                ->get();
        }

        $seoOverride = [
            'title' => "{$post->title} - Ubu Hospitality Blog",
            'description' => $post->excerpt ?: substr(strip_tags($post->content), 0, 160),
            'image' => $post->featured_image,
        ];

        return view('blog.show', compact('post', 'relatedPosts', 'relatedProperties', 'seoOverride'));
    }
}
