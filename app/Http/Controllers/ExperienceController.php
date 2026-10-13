<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::published()
            ->with(['brand', 'property'])
            ->ordered()
            ->get();

        $seoOverride = [
            'title' => 'Pengalaman & Aktivitas Menarik - Ubu Hospitality',
            'description' => 'Floating breakfast di private pool, jeep Merapi lava tour, dan private chef BBQ untuk melengkapi liburan istimewa Anda di Yogyakarta.',
        ];

        return view('experiences.index', compact('experiences', 'seoOverride'));
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
