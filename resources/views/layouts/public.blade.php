<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @php
        $seoService = app(\App\Services\Seo\SeoService::class);
        $seo = $seoService->buildMetadata($seoOverride ?? []);
        $navService = app(\App\Services\Navigation\NavigationService::class);
        $headerItems = $navService->getMenu('header_main');
        $footerStay = $navService->getMenu('footer_stay');
        $footerCompany = $navService->getMenu('footer_company');
        $footerPartnership = $navService->getMenu('footer_partnership');
        $footerHelp = $navService->getMenu('footer_help');
        $footerLegal = $navService->getMenu('footer_legal');
        $companyName = \App\Models\Setting::get('company_name', 'PT Ubu Hospitality Indonesia');
        $waUrl = \App\Models\Setting::get('contact_whatsapp_url', 'https://wa.me/6281234567890');
    @endphp

    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/branding/favicon.png') }}" type="image/png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seo['og_type'] }}">
    <meta property="og:url" content="{{ $seo['canonical'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:image" content="{{ $seo['og_image'] }}">
    <meta property="og:locale" content="{{ $seo['og_locale'] }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Flatpickr Date Picker CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Custom Structured CSS -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">

    <!-- Structured Data (Schema.org JSON-LD) -->
    <script type="application/ld+json">
        {!! json_encode($seoService->getOrganizationSchema()) !!}
    </script>
    @stack('schema')
    @stack('styles')
</head>
<body>
    <!-- Top Announcement Bar (if promo exists) -->
    @php
        $topPromo = \App\Models\Promotion::published()->where('is_popup', false)->latest('priority')->first();
    @endphp
    @if($topPromo)
        <div class="bg-dark text-white py-1 px-3 text-center small d-none d-md-block" style="background-color: #121815 !important;">
            <span class="text-warning fw-bold"><i class="bi bi-tag-fill me-1"></i> {{ $topPromo->title }}:</span>
            {{ $topPromo->subtitle }}
            <a href="{{ route('offer.index') }}" class="text-white text-decoration-underline ms-2 fw-semibold">Lihat Penawaran <i class="bi bi-arrow-right"></i></a>
        </div>
    @endif

    <!-- Header Navbar -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg site-navbar">
            <div class="container">
                <!-- Brand Logo (Authentic Logo from ubuvilla.codeapps.xyz) -->
                <a class="navbar-brand navbar-brand-logo d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <img src="{{ asset('images/branding/logo-dark.svg') }}" alt="Ubu Hospitality Logo" height="40" class="d-inline-block">
                    <div class="d-flex flex-column">
                        <span class="navbar-brand-title">UBU HOSPITALITY</span>
                        <span class="navbar-brand-sub">ASSET MANAGEMENT</span>
                    </div>
                </a>

                <!-- Mobile Buttons -->
                <div class="d-flex align-items-center gap-2 d-lg-none">
                    <a href="{{ route('stay.index') }}" class="btn btn-sm btn-ubu-primary">
                        <i class="bi bi-search"></i> Cari
                    </a>
                    <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas">
                        <i class="bi bi-list fs-2 text-dark"></i>
                    </button>
                </div>

                <!-- Desktop Nav Items (Exact Structure from Vendor Brief) -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                    <ul class="navbar-nav align-items-center gap-1 me-2">
                        <!-- 1. ABOUT UBU -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('about*') || request()->is('contact*') ? 'active' : '' }}" href="{{ route('about') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ABOUT UBU
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('about') }}"><i class="bi bi-info-circle me-2 text-muted"></i> Ubu Hospitality</a></li>
                                <li><a class="dropdown-item" href="{{ route('about') }}#company_story"><i class="bi bi-book me-2 text-muted"></i> Kisah Kami</a></li>
                                <li><a class="dropdown-item" href="{{ url('/#brands') }}"><i class="bi bi-collection me-2 text-muted"></i> Brand Kami</a></li>
                                <li><a class="dropdown-item" href="{{ route('about') }}#hospitality_standards"><i class="bi bi-shield-check me-2 text-muted"></i> Standar Hospitality</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item" href="{{ route('contact') }}"><i class="bi bi-envelope me-2 text-muted"></i> Kontak</a></li>
                            </ul>
                        </li>

                        <!-- 2. STAY -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('stay*') || request()->is('brand*') ? 'active' : '' }}" href="{{ route('stay.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                STAY
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('brand.show', 'ubu-villa') }}">
                                        <div class="fw-bold text-dark"><i class="bi bi-building me-1 text-success"></i> Ubu Villa</div>
                                        <small class="text-muted d-block ps-4">Private Pool Luxury Villa</small>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('brand.show', 'buruj-villa') }}">
                                        <div class="fw-bold text-dark"><i class="bi bi-shield-check me-1 text-warning"></i> Buruj Villa</div>
                                        <small class="text-muted d-block ps-4">Family Syariah Compliant</small>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('brand.show', 'ubu-glamping') }}">
                                        <div class="fw-bold text-dark"><i class="bi bi-tree me-1 text-info"></i> Glamping</div>
                                        <small class="text-muted d-block ps-4">Nature & Luxury Escape</small>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item" href="{{ route('stay.index') }}"><i class="bi bi-grid me-2 text-muted"></i> Semua Properti & Resort</a></li>
                            </ul>
                        </li>

                        <!-- 3. EXPERIENCE -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('experience*') || request()->is('blog*') ? 'active' : '' }}" href="{{ route('experience.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                EXPERIENCE
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('experience.index') }}"><i class="bi bi-stars me-2 text-muted"></i> Pengalaman Tambahan</a></li>
                                <li><a class="dropdown-item" href="{{ route('experience.index', ['category' => 'event']) }}"><i class="bi bi-people me-2 text-muted"></i> Acara dan Pertemuan</a></li>
                                <li><a class="dropdown-item" href="{{ route('experience.index', ['category' => 'tour']) }}"><i class="bi bi-compass me-2 text-muted"></i> Pengalaman Lokal</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item" href="{{ route('blog.index') }}"><i class="bi bi-journal-text me-2 text-muted"></i> Panduan Perjalanan</a></li>
                            </ul>
                        </li>

                        <!-- 4. OFFER -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('offer*') ? 'active' : '' }}" href="{{ route('offer.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                OFFER
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('offer.index') }}"><i class="bi bi-tag-fill me-2 text-danger"></i> Promo Aktif</a></li>
                                <li><a class="dropdown-item" href="{{ route('offer.index') }}#coupons"><i class="bi bi-ticket-perforated me-2 text-success"></i> Promo Pengguna Baru</a></li>
                            </ul>
                        </li>

                        <!-- 5. PARTNERSHIP -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('partnership*') ? 'active' : '' }}" href="{{ route('partnership.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                PARTNERSHIP
                            </a>
                            <ul class="dropdown-menu border shadow-sm dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('partnership.index') }}"><i class="bi bi-building-gear me-2 text-muted"></i> Pengelolaan Properti</a></li>
                                <li><a class="dropdown-item" href="{{ route('partnership.index') }}#partnership_models"><i class="bi bi-diagram-3 me-2 text-muted"></i> Model Kerja Sama</a></li>
                                <li><a class="dropdown-item" href="{{ route('stay.index') }}"><i class="bi bi-images me-2 text-muted"></i> Portofolio</a></li>
                                <li><a class="dropdown-item" href="{{ route('faq') }}"><i class="bi bi-question-circle me-2 text-muted"></i> FAQ Pemilik</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item fw-bold text-success" href="{{ route('partnership.index') }}#submit"><i class="bi bi-plus-circle me-2"></i> Ajukan Properti</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Fungsi Tambahan: Pencarian, WhatsApp, Bahasa, Cek Ketersediaan -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Quick Search Icon -->
                        <a href="{{ route('stay.index') }}" class="btn btn-sm btn-light border rounded-circle p-0 d-flex align-items-center justify-content-center text-dark" style="width: 32px; height: 32px;" title="Cari Properti">
                            <i class="bi bi-search small"></i>
                        </a>

                        <!-- WhatsApp Direct Support -->
                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-2 d-none d-xl-inline-flex align-items-center gap-1" title="WhatsApp Customer Support">
                            <i class="bi bi-whatsapp"></i> <span class="small fw-semibold">WhatsApp</span>
                        </a>

                        <!-- Pilihan Bahasa ID/EN -->
                        <div class="btn-group btn-group-sm border rounded-pill p-1 bg-light">
                            <a href="?lang=id" class="btn btn-sm rounded-pill py-0 px-2 {{ app()->getLocale() === 'id' ? 'btn-white bg-white fw-bold shadow-sm text-dark' : 'text-muted border-0' }}">ID</a>
                            <a href="?lang=en" class="btn btn-sm rounded-pill py-0 px-2 {{ app()->getLocale() === 'en' ? 'btn-white bg-white fw-bold shadow-sm text-dark' : 'text-muted border-0' }}">EN</a>
                        </div>

                        <!-- Tombol Cek Ketersediaan Utama -->
                        <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary btn-sm px-3 ms-1 text-nowrap">
                            <i class="bi bi-calendar-check me-1"></i> Cek Ketersediaan
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Offcanvas Drawer -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenuOffcanvas">
        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title font-serif fw-bold text-dark mb-0">UBU HOSPITALITY</h5>
                <small class="text-muted">Master of Warmth & Elegance</small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-4">
            <div>
                <div class="accordion accordion-flush" id="mobileNavAccordion">
                    <!-- 1. ABOUT UBU -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-0 py-2 fs-6 fw-bold text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout">
                                ABOUT UBU
                            </button>
                        </h2>
                        <div id="collapseAbout" class="accordion-collapse collapse" data-bs-parent="#mobileNavAccordion">
                            <ul class="list-unstyled ps-3 py-1 mb-2">
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('about') }}">Ubu Hospitality</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('about') }}#company_story">Kisah Kami</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ url('/#brands') }}">Brand Kami</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('about') }}#hospitality_standards">Standar Hospitality</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('contact') }}">Kontak</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- 2. STAY -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-0 py-2 fs-6 fw-bold text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStay">
                                STAY
                            </button>
                        </h2>
                        <div id="collapseStay" class="accordion-collapse collapse" data-bs-parent="#mobileNavAccordion">
                            <ul class="list-unstyled ps-3 py-1 mb-2">
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('brand.show', 'ubu-villa') }}">Ubu Villa</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('brand.show', 'buruj-villa') }}">Buruj Villa (Syariah)</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('brand.show', 'ubu-glamping') }}">Ubu Glamping</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('stay.index') }}">Semua Properti & Resort</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- 3. EXPERIENCE -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-0 py-2 fs-6 fw-bold text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExperience">
                                EXPERIENCE
                            </button>
                        </h2>
                        <div id="collapseExperience" class="accordion-collapse collapse" data-bs-parent="#mobileNavAccordion">
                            <ul class="list-unstyled ps-3 py-1 mb-2">
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('experience.index') }}">Pengalaman Tambahan</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('experience.index', ['category' => 'event']) }}">Acara dan Pertemuan</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('experience.index', ['category' => 'tour']) }}">Pengalaman Lokal</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('blog.index') }}">Panduan Perjalanan</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- 4. OFFER -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-0 py-2 fs-6 fw-bold text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOffer">
                                OFFER
                            </button>
                        </h2>
                        <div id="collapseOffer" class="accordion-collapse collapse" data-bs-parent="#mobileNavAccordion">
                            <ul class="list-unstyled ps-3 py-1 mb-2">
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('offer.index') }}">Promo Aktif</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('offer.index') }}#coupons">Promo Pengguna Baru</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- 5. PARTNERSHIP -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed px-0 py-2 fs-6 fw-bold text-dark bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartnership">
                                PARTNERSHIP
                            </button>
                        </h2>
                        <div id="collapsePartnership" class="accordion-collapse collapse" data-bs-parent="#mobileNavAccordion">
                            <ul class="list-unstyled ps-3 py-1 mb-2">
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('partnership.index') }}">Pengelolaan Properti</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('partnership.index') }}#partnership_models">Model Kerja Sama</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('stay.index') }}">Portofolio</a></li>
                                <li class="py-1"><a class="text-decoration-none text-muted small" href="{{ route('faq') }}">FAQ Pemilik</a></li>
                                <li class="py-1"><a class="text-decoration-none text-success fw-bold small" href="{{ route('partnership.index') }}#submit">Ajukan Properti</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-top">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted small">Pilihan Bahasa</span>
                    <div class="btn-group btn-group-sm">
                        <a href="?lang=id" class="btn btn-outline-dark btn-sm {{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
                        <a href="?lang=en" class="btn btn-outline-dark btn-sm {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                    </div>
                </div>
                <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary w-100 py-2 mb-2">
                    <i class="bi bi-calendar-check me-1"></i> Cek Ketersediaan
                </a>
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-outline-success w-100 py-2">
                    <i class="bi bi-whatsapp me-1"></i> Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <!-- Col 1: Brand Info (Authentic Logo & Contacts) -->
                <div class="col-lg-4 col-md-6">
                    <img src="{{ asset('images/branding/logo-footer.png') }}" alt="Ubu Hospitality Logo" height="46" class="mb-3 d-block">
                    <h4 class="text-white font-serif mb-2">UBU HOSPITALITY</h4>
                    <p class="text-white small mb-3">
                        Perusahaan manajemen aset hospitality terkemuka di Indonesia yang mengelola portfolio villa privat, akomodasi syariah terpercaya, dan glamping berkarakter.
                    </p>
                    <p class="small text-white mb-1">
                        <i class="bi bi-geo-alt text-warning me-1"></i> {{ \App\Models\Setting::get('contact_address', 'Jl. Gito Gati No. 88, Sariharjo, Ngaglik, Sleman, D.I. Yogyakarta 55581') }}
                    </p>
                    <p class="small text-white mb-1">
                        <i class="bi bi-telephone text-warning me-1"></i> {{ \App\Models\Setting::get('contact_phone', '0823-2000-3297') }}
                    </p>
                    <p class="small text-white mb-3">
                        <i class="bi bi-envelope text-warning me-1"></i> {{ \App\Models\Setting::get('contact_email', 'reservation@ubuvilla.com') }}
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ \App\Models\Setting::get('social_whatsapp', 'https://api.whatsapp.com/send?phone=+6282320003297') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_instagram', 'https://www.instagram.com/ubuvilla/') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_tiktok', 'https://www.tiktok.com/@ubuvilla') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;" title="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_youtube', 'https://www.youtube.com/@ubuvillaindonesia') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_facebook', 'https://www.facebook.com/ubuvillaindonesia/') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;" title="Facebook"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>

                <!-- Col 2: Stay Portfolio -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">STAY</h6>
                    <ul class="footer-links">
                        @foreach($footerStay as $item)
                            <li><a href="{{ url($item->url) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 3: Company -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">COMPANY</h6>
                    <ul class="footer-links">
                        @foreach($footerCompany as $item)
                            <li><a href="{{ url($item->url) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 4: Partnership & Bantuan -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-title">PARTNERSHIP</h6>
                    <ul class="footer-links mb-4">
                        @foreach($footerPartnership as $item)
                            <li><a href="{{ url($item->url) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>

                    <h6 class="footer-title">BANTUAN</h6>
                    <ul class="footer-links">
                        @foreach($footerHelp as $item)
                            <li><a href="{{ url($item->url) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 5: Legal -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-title">LEGAL</h6>
                    <ul class="footer-links">
                        @foreach($footerLegal as $item)
                            <li><a href="{{ url($item->url) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                </div>
                <div class="text-muted">
                    Reservations powered by SENTEC. Payments secured with DOKU.
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="{{ $waUrl }}" target="_blank" class="floating-whatsapp" title="Hubungi WhatsApp Customer Support">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Bootstrap 5 Bundle JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Flatpickr Date Picker JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Global Flash Feedback Notifications -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1b3b2b',
                timer: 4000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#b91c1c'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Pemberitahuan',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#c5a059'
            });
        @endif
    </script>

    @stack('scripts')
</body>
</html>
