<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $query = Experience::published()
            ->with(['brand', 'property'])
            ->ordered();

        if ($category) {
            if ($category === 'tour') {
                $query->whereIn('category', ['tour', 'adventure']);
            } else {
                $query->where('category', $category);
            }
        }

        $experiences = $query->get();

        $categoryTitles = [
            'event' => 'Acara dan Pertemuan',
            'tour' => 'Pengalaman Lokal & Tur',
            'culinary' => 'Kuliner & Dining',
            'wellness' => 'Wellness & Spa',
            'service' => 'Layanan Fotografi & Mobil',
        ];

        $activeCategoryTitle = $category && isset($categoryTitles[$category]) ? $categoryTitles[$category] : null;

        $seoOverride = [
            'title' => ($activeCategoryTitle ? $activeCategoryTitle.' - ' : '').'Pengalaman & Aktivitas Menarik - Ubu Hospitality',
            'description' => 'Floating breakfast di private pool, jeep Merapi lava tour, dan private chef BBQ untuk melengkapi liburan istimewa Anda di Yogyakarta.',
        ];

        return view('experiences.index', compact('experiences', 'seoOverride', 'category', 'activeCategoryTitle'));
    }

    public function show(string $slug): View
    {
        $experience = Experience::where('slug', $slug)
            ->published()
            ->with(['brand', 'property'])
            ->firstOrFail();

        $relatedExperiences = Experience::published()
            ->where('id', '!=', $experience->id)
            ->take(3)
            ->get();

        $seoOverride = [
            'title' => "{$experience->title} - Ubu Hospitality",
            'description' => $experience->short_description,
            'image' => $experience->featured_image,
        ];

        return view('experiences.show', compact('experience', 'relatedExperiences', 'seoOverride'));
    }
}
