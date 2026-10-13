<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = Page::where('slug', 'about')->with('activeSections')->first();
        $brands = Brand::active()->ordered()->withCount('properties')->get();

        $seoOverride = [
            'title' => 'Tentang Ubu Hospitality - Master of Warmth & Authentic Hospitality',
            'description' => 'Mengenal Ubu Hospitality, perusahaan manajemen aset villa dan glamping di Yogyakarta yang menaungi Ubu Villa dan Buruj Villa.',
        ];

        return view('pages.about', compact('page', 'brands', 'seoOverride'));
    }

    public function contact(): View
    {
        $page = Page::where('slug', 'contact')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Kontak & Bantuan Reservasi - Ubu Hospitality',
            'description' => 'Hubungi customer service dan tim reservasi Ubu Hospitality melalui WhatsApp, telepon, atau email.',
        ];

        return view('pages.contact', compact('page', 'seoOverride'));
    }

    public function faq(): View
    {
        $page = Page::where('slug', 'faq')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Tanya Jawab (FAQ) - Ubu Hospitality',
            'description' => 'Pertanyaan umum mengenai proses reservasi, kebijakan check-in, aturan syariah di Buruj Villa, dan fasilitas villa Ubu.',
        ];

        return view('pages.faq', compact('page', 'seoOverride'));
    }

    public function privacyPolicy(): View
    {
        $page = Page::where('slug', 'privacy-policy')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Kebijakan Privasi - Ubu Hospitality',
            'description' => 'Kebijakan perlindungan data pribadi dan privasi pengunjung website Ubu Hospitality.',
        ];

        return view('pages.legal', compact('page', 'seoOverride'));
    }

    public function terms(): View
    {
        $page = Page::where('slug', 'terms')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Syarat dan Ketentuan Reservasi - Ubu Hospitality',
            'description' => 'Syarat dan ketentuan pemesanan villa, aturan pembatalan, dan tata tertib menginap di properti Ubu Hospitality.',
        ];

        return view('pages.legal', compact('page', 'seoOverride'));
    }

    public function cookies(): View
    {
        $page = Page::where('slug', 'cookies')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Kebijakan Cookie - Ubu Hospitality',
            'description' => 'Informasi penggunaan cookie dan teknologi pelacakan pada website Ubu Hospitality.',
        ];

        return view('pages.legal', compact('page', 'seoOverride'));
    }
}
