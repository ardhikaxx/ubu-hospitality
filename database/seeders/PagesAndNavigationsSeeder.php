<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use App\Models\NavigationMenu;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PagesAndNavigationsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pages
        // Page: About
        $aboutPage = Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'title_id' => 'Tentang Ubu Hospitality',
                'title_en' => 'About Ubu Hospitality',
                'subtitle_id' => 'Perusahaan Manajemen Aset Hospitality Terkemuka di Yogyakarta',
                'subtitle_en' => 'Leading Hospitality Asset Management in Yogyakarta',
                'status' => 'published',
                'meta_title_id' => 'Tentang Kami - Ubu Hospitality',
                'meta_title_en' => 'About Us - Ubu Hospitality',
                'meta_description_id' => 'Profil resmi Ubu Hospitality, perusahaan manajemen aset villa dan glamping premium yang menaungi Ubu Villa dan Buruj Villa.',
                'meta_description_en' => 'Official profile of Ubu Hospitality, premier hospitality management overseeing luxury brands like Ubu Villa and Buruj Villa.',
            ]
        );

        PageSection::updateOrCreate(
            ['page_id' => $aboutPage->id, 'section_key' => 'company_story'],
            [
                'title_id' => 'Kisah & Dedikasi Kami',
                'title_en' => 'Our Story & Purpose',
                'subtitle_id' => 'Menghadirkan Kehangatan Autentik Nusantara',
                'subtitle_en' => 'Delivering Authentic Indonesian Hospitality Warmth',
                'content_id' => 'Ubu Hospitality berdiri sebagai perusahaan manajemen aset hospitality yang berfokus pada pengelolaan villa privat, glamping eksklusif, dan akomodasi berkarakter di Indonesia. Kami memadukan standar operasional berkelas dunia dengan sentuhan keramahan lokal Yogyakarta yang tulus. Sebagai perusahaan induk, Ubu Hospitality menaungi berbagai brand terpercaya seperti Ubu Villa dan Buruj Villa (konsep syariah), serta terus berinovasi membuka potensi destinasi baru.',
                'content_en' => 'Ubu Hospitality operates as a premier hospitality asset management company dedicated to managing private villas, luxury glamping, and distinctive accommodations. We blend world-class operational excellence with genuine Javanese hospitality warmth.',
                'media_path' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        PageSection::updateOrCreate(
            ['page_id' => $aboutPage->id, 'section_key' => 'hospitality_standards'],
            [
                'title_id' => 'Standar Hospitality Ubu',
                'title_en' => 'The Ubu Hospitality Standards',
                'subtitle_id' => 'Tiga Pilar Layanan Utama',
                'subtitle_en' => 'Three Core Service Pillars',
                'content_id' => 'Kami berkomitmen menjaga kualitas setiap properti yang kami kelola melalui inspeksi kebersihan berlapis, privasi tamu tanpa kompromi, dan layanan personal yang mengutamakan kebutuhan keluarga serta pasangan.',
                'content_en' => 'We maintain uncompromised cleanliness inspections, absolute guest privacy, and attentive personal care tailored to families and couples.',
                'extra_data' => [
                    [
                        'icon' => 'bi-shield-check',
                        'title_id' => 'Kebersihan & Sanitasi Menyeluruh',
                        'title_en' => 'Hospitality-Grade Sanitization',
                        'desc_id' => 'Setiap kamar dan kolam renang melewati standar sterilisasi ketat sebelum tamu check-in.',
                        'desc_en' => 'Every suite and private pool undergoes rigorous multi-step inspection before each arrival.',
                    ],
                    [
                        'icon' => 'bi-eye-slash',
                        'title_id' => 'Jaminan Privasi Penuh',
                        'title_en' => 'Absolute Privacy Guarantee',
                        'desc_id' => 'Tata ruang properti dirancang terlindung dari akses visual publik sehingga Anda dapat menikmati waktu santai sepenuhnya.',
                        'desc_en' => 'Thoughtfully engineered architectures prevent external sightlines, securing your private peace.',
                    ],
                    [
                        'icon' => 'bi-heart-pulse',
                        'title_id' => 'Butler & Pelayanan Responsif',
                        'title_en' => 'Attentive Butler Care',
                        'desc_id' => 'Staf kami selalu siap sedia membantu kebutuhan tamu dengan keramahan khas nusantara.',
                        'desc_en' => 'Dedicated hosts ready to assist your needs with graceful attentiveness.',
                    ],
                ],
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // Page: Partnership
        $partnershipPage = Page::firstOrCreate(
            ['slug' => 'partnership'],
            [
                'title_id' => 'Kemitraan Pengelolaan Properti',
                'title_en' => 'Property Partnership & Asset Management',
                'subtitle_id' => 'Optimalkan Potensi Properti Anda Bersama Ubu Hospitality',
                'subtitle_en' => 'Maximize Your Property Yield with Ubu Hospitality',
                'status' => 'published',
                'meta_title_id' => 'Kerja Sama Pengelolaan Villa & Properti - Ubu Hospitality',
                'meta_title_en' => 'Villa & Property Management Partnership - Ubu Hospitality',
                'meta_description_id' => 'Bergabunglah menjadi mitra pemilik properti Ubu Hospitality. Solusi end-to-end manajemen operasional, pemasaran digital, dan pemeliharaan aset villa di Yogyakarta.',
                'meta_description_en' => 'Partner with Ubu Hospitality for end-to-end villa asset management, digital sales distribution, and premium operational care.',
            ]
        );

        PageSection::updateOrCreate(
            ['page_id' => $partnershipPage->id, 'section_key' => 'partnership_models'],
            [
                'title_id' => 'Pilihan Model Kerja Sama',
                'title_en' => 'Cooperation Models',
                'subtitle_id' => 'Fleksibel, Transparan, dan Saling Menguntungkan',
                'subtitle_en' => 'Flexible, Transparent, and Profitable',
                'content_id' => 'Kami menawarkan berbagai skema kerja sama pengelolaan aset properti yang disesuaikan dengan profil dan kesiapan aset Anda.',
                'content_en' => 'We provide structured management models tailored to your property readiness and financial goals.',
                'extra_data' => [
                    [
                        'icon' => 'bi-gem',
                        'title_id' => 'Full Asset & Operations Management',
                        'title_en' => 'Full Asset & Operations Management',
                        'desc_id' => 'Kami mengelola seluruh aspek mulai dari pemasaran, penerimaan tamu, housekeeping, maintenance, hingga laporan keuangan bulanan transparan.',
                        'desc_en' => 'Complete turnkey service encompassing sales, guest handling, daily housekeeping, routine maintenance, and monthly financial reports.',
                    ],
                    [
                        'icon' => 'bi-pie-chart',
                        'title_id' => 'Revenue Sharing Bersih',
                        'title_en' => 'Transparent Revenue Share',
                        'desc_id' => 'Skema bagi hasil pendapatan kotor atau bersih yang adil, memungkinkan pemilik menikmati pasif income optimal.',
                        'desc_en' => 'Equitable profit and revenue distribution allowing property owners to earn consistent passive returns.',
                    ],
                    [
                        'icon' => 'bi-building-gear',
                        'title_id' => 'Konsultasi Pengembangan & Branding',
                        'title_en' => 'Development & Branding Consultation',
                        'desc_id' => 'Bagi pemilik tanah atau bangunan yang ingin mendesain villa atau glamping baru agar sesuai standar pasar hospitality kekinian.',
                        'desc_en' => 'Advisory for landowners or developers crafting new villas or glamping sites optimized for modern market yield.',
                    ],
                ],
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // Page: Contact
        Page::firstOrCreate(
            ['slug' => 'contact'],
            [
                'title_id' => 'Hubungi Kami',
                'title_en' => 'Contact Us',
                'subtitle_id' => 'Tim Layanan Pelanggan & Reservasi Ubu Hospitality',
                'subtitle_en' => 'Customer Care & Reservation Support',
                'status' => 'published',
            ]
        );

        // Page: FAQ
        Page::firstOrCreate(
            ['slug' => 'faq'],
            [
                'title_id' => 'Tanya Jawab (FAQ)',
                'title_en' => 'Frequently Asked Questions',
                'subtitle_id' => 'Pertanyaan yang Sering Diajukan Seputar Reservasi dan Kebijakan Menginap',
                'subtitle_en' => 'Common Inquiries on Booking and Property Policies',
                'status' => 'published',
            ]
        );

        // Page: Legal Pages
        Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title_id' => 'Kebijakan Privasi',
                'title_en' => 'Privacy Policy',
                'subtitle_id' => 'Komitmen Kami Melindungi Data Pribadi Anda',
                'subtitle_en' => 'Our Commitment to Protecting Your Personal Data',
                'status' => 'published',
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'terms'],
            [
                'title_id' => 'Syarat dan Ketentuan',
                'title_en' => 'Terms and Conditions',
                'subtitle_id' => 'Ketentuan Penggunaan Layanan dan Reservasi',
                'subtitle_en' => 'Terms of Service and Reservation Policies',
                'status' => 'published',
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'cookies'],
            [
                'title_id' => 'Kebijakan Cookie',
                'title_en' => 'Cookie Policy',
                'subtitle_id' => 'Informasi Penggunaan Cookie pada Website',
                'subtitle_en' => 'Cookie Usage Information',
                'status' => 'published',
            ]
        );

        // 2. Navigation Menus & Items
        // Menu 1: Header Main
        $headerMenu = NavigationMenu::firstOrCreate(
            ['location' => 'header_main'],
            ['name' => 'Header Main Navigation']
        );

        $headerItems = [
            ['title_id' => 'ABOUT UBU', 'title_en' => 'ABOUT UBU', 'url' => '/about', 'route' => 'about', 'order' => 1],
            ['title_id' => 'STAY', 'title_en' => 'STAY', 'url' => '/stay', 'route' => 'stay.index', 'order' => 2],
            ['title_id' => 'EXPERIENCE', 'title_en' => 'EXPERIENCE', 'url' => '/experience', 'route' => 'experience.index', 'order' => 3],
            ['title_id' => 'OFFER', 'title_en' => 'OFFER', 'url' => '/offer', 'route' => 'offer.index', 'order' => 4],
            ['title_id' => 'PARTNERSHIP', 'title_en' => 'PARTNERSHIP', 'url' => '/partnership', 'route' => 'partnership.index', 'order' => 5],
        ];

        foreach ($headerItems as $item) {
            NavigationItem::updateOrCreate(
                ['menu_id' => $headerMenu->id, 'url' => $item['url']],
                [
                    'title_id' => $item['title_id'],
                    'title_en' => $item['title_en'],
                    'route_name' => $item['route'],
                    'sort_order' => $item['order'],
                    'is_active' => true,
                ]
            );
        }

        // Menu 2: Footer Stay
        $footerStay = NavigationMenu::firstOrCreate(['location' => 'footer_stay'], ['name' => 'Footer Stay']);
        NavigationItem::firstOrCreate(['menu_id' => $footerStay->id, 'url' => '/brand/ubu-villa'], ['title_id' => 'Ubu Villa', 'title_en' => 'Ubu Villa', 'sort_order' => 1]);
        NavigationItem::firstOrCreate(['menu_id' => $footerStay->id, 'url' => '/brand/buruj-villa'], ['title_id' => 'Buruj Villa (Syariah)', 'title_en' => 'Buruj Villa (Syariah)', 'sort_order' => 2]);
        NavigationItem::firstOrCreate(['menu_id' => $footerStay->id, 'url' => '/brand/ubu-glamping'], ['title_id' => 'Ubu Glamping', 'title_en' => 'Ubu Glamping', 'sort_order' => 3]);
        NavigationItem::firstOrCreate(['menu_id' => $footerStay->id, 'url' => '/stay?private_pool=1'], ['title_id' => 'Private Pool Villas', 'title_en' => 'Private Pool Villas', 'sort_order' => 4]);

        // Menu 3: Footer Company
        $footerCompany = NavigationMenu::firstOrCreate(['location' => 'footer_company'], ['name' => 'Footer Company']);
        NavigationItem::firstOrCreate(['menu_id' => $footerCompany->id, 'url' => '/about'], ['title_id' => 'Tentang Ubu', 'title_en' => 'About Ubu', 'sort_order' => 1]);
        NavigationItem::firstOrCreate(['menu_id' => $footerCompany->id, 'url' => '/brand/ubu-villa'], ['title_id' => 'Brand Kami', 'title_en' => 'Our Brands', 'sort_order' => 2]);
        NavigationItem::firstOrCreate(['menu_id' => $footerCompany->id, 'url' => '/blog'], ['title_id' => 'Inspirasi & Blog', 'title_en' => 'Blog & Inspiration', 'sort_order' => 3]);

        // Menu 4: Footer Partnership
        $footerPartnership = NavigationMenu::firstOrCreate(['location' => 'footer_partnership'], ['name' => 'Footer Partnership']);
        NavigationItem::firstOrCreate(['menu_id' => $footerPartnership->id, 'url' => '/partnership'], ['title_id' => 'Kerja Sama Pengelolaan', 'title_en' => 'Property Partnership', 'sort_order' => 1]);
        NavigationItem::firstOrCreate(['menu_id' => $footerPartnership->id, 'url' => '/partnership#submit'], ['title_id' => 'Ajukan Properti Anda', 'title_en' => 'Submit Your Property', 'sort_order' => 2]);

        // Menu 5: Footer Help
        $footerHelp = NavigationMenu::firstOrCreate(['location' => 'footer_help'], ['name' => 'Footer Help']);
        NavigationItem::firstOrCreate(['menu_id' => $footerHelp->id, 'url' => '/faq'], ['title_id' => 'Tanya Jawab (FAQ)', 'title_en' => 'FAQ', 'sort_order' => 1]);
        NavigationItem::firstOrCreate(['menu_id' => $footerHelp->id, 'url' => '/contact'], ['title_id' => 'Bantuan Reservasi & Kontak', 'title_en' => 'Reservation Help & Contact', 'sort_order' => 2]);

        // Menu 6: Footer Legal
        $footerLegal = NavigationMenu::firstOrCreate(['location' => 'footer_legal'], ['name' => 'Footer Legal']);
        NavigationItem::firstOrCreate(['menu_id' => $footerLegal->id, 'url' => '/privacy-policy'], ['title_id' => 'Kebijakan Privasi', 'title_en' => 'Privacy Policy', 'sort_order' => 1]);
        NavigationItem::firstOrCreate(['menu_id' => $footerLegal->id, 'url' => '/terms'], ['title_id' => 'Syarat & Ketentuan', 'title_en' => 'Terms & Conditions', 'sort_order' => 2]);
        NavigationItem::firstOrCreate(['menu_id' => $footerLegal->id, 'url' => '/cookies'], ['title_id' => 'Kebijakan Cookie', 'title_en' => 'Cookie Policy', 'sort_order' => 3]);
    }
}
