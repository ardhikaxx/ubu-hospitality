<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Experience;
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

    public function celebrity(): View
    {
        $page = Page::where('slug', 'celebrity')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Celebrity & Influencer Staycation - Ubu Hospitality',
            'description' => 'Melihat keseruan liburan dan staycation para selebriti, artis, dan figur publik ternama di villa mewah Ubu Hospitality.',
        ];

        return view('pages.celebrity', compact('page', 'seoOverride'));
    }

    public function packages(): View
    {
        $page = Page::where('slug', 'packages')->with('activeSections')->first();
        $experiences = Experience::published()->ordered()->get();

        $seoOverride = [
            'title' => 'Paket Wisata & Layanan Tambahan (Special Packages) - Ubu Hospitality',
            'description' => 'Layanan eksklusif villa mulai dari In-Villa BBQ, Floating Breakfast, Photo Service, hingga Lava Tour Jeep di Yogyakarta.',
        ];

        return view('pages.packages', compact('page', 'experiences', 'seoOverride'));
    }

    public function lifeAtUbu(): View
    {
        $page = Page::where('slug', 'life-at-ubu')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Life at Ubu - Budaya & Standar Pelayanan Hospitality',
            'description' => 'Mengenal dedikasi, kehangatan budaya lokal, dan standar pelayanan butler profesional di balik Ubu Hospitality.',
        ];

        return view('pages.life-at-ubu', compact('page', 'seoOverride'));
    }

    public function csr(): View
    {
        $page = Page::where('slug', 'csr')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'CSR & Keberlanjutan Komunitas - Ubu Hospitality',
            'description' => 'Komitmen Ubu Hospitality dalam pemberdayaan masyarakat lokal, pelestarian lingkungan, dan pariwisata berkelanjutan di Yogyakarta.',
        ];

        return view('pages.csr', compact('page', 'seoOverride'));
    }

    public function career(): View
    {
        $page = Page::where('slug', 'career')->with('activeSections')->first();

        $seoOverride = [
            'title' => 'Karir & Peluang Bergabung - Ubu Hospitality',
            'description' => 'Bergabunglah bersama keluarga besar Ubu Hospitality dan kembangkan potensi terbaik Anda di industri manajemen hospitality.',
        ];

        return view('pages.career', compact('page', 'seoOverride'));
    }
}
