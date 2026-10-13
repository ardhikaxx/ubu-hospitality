<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        $promotions = Promotion::published()
            ->with(['brands', 'properties'])
            ->orderBy('priority', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $seoOverride = [
            'title' => 'Penawaran Spesial & Promo Menginap - Ubu Hospitality',
            'description' => 'Dapatkan promo diskon menginap eksklusif di Ubu Villa dan Buruj Villa Yogyakarta. Penawaran terbatas dengan harga terbaik.',
        ];

        return view('offers.index', compact('promotions', 'seoOverride'));
    }

    public function show(string $slug): View
    {
        $promotion = Promotion::where('slug', $slug)
            ->published()
            ->with(['brands', 'properties'])
            ->firstOrFail();

        $seoOverride = [
            'title' => "Promo {$promotion->code}: {$promotion->title} - Ubu Hospitality",
            'description' => $promotion->subtitle ?: $promotion->description,
            'image' => $promotion->banner_image,
        ];

        return view('offers.show', compact('promotion', 'seoOverride'));
    }
}
