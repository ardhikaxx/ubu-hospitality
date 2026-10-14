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
                <a class="navbar-brand navbar-brand-logo d-flex flex-row align-items-center gap-2" href="{{ url('/') }}">
                    <img src="{{ asset('images/branding/logo-dark.svg') }}" alt="Ubu Hospitality Logo" height="42" class="d-inline-block">
                    <div class="d-flex flex-column text-start">
                        <span class="navbar-brand-title">UBU HOSPITALITY</span>
                        <span class="navbar-brand-sub">ASSET MANAGEMENT</span>
                    </div>
                </a>

                <!-- Mobile Actions (Compact & Modern Draw Menu Trigger) -->
                <div class="mobile-nav-actions d-flex align-items-center gap-2 d-lg-none">
                    <a href="{{ route('stay.index') }}" class="mobile-action-btn mobile-search-btn" title="Cari Villa & Resort" aria-label="Cari Villa">
                        <i class="bi bi-search"></i>
                    </a>
                    <button class="mobile-action-btn mobile-drawer-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas" aria-label="Buka Menu Navigasi">
                        <span class="drawer-hamburger-bars">
                            <span class="bar bar-1"></span>
                            <span class="bar bar-2"></span>
                            <span class="bar bar-3"></span>
                        </span>
                    </button>
                </div>

                <!-- Desktop Nav Items (Exact Structure from Vendor Brief) -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                    <ul class="navbar-nav align-items-center gap-1 me-2">
                        <!-- 1. ABOUT UBU -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('about*') || request()->is('contact*') || request()->is('life-at-ubu*') || request()->is('csr*') || request()->is('career*') ? 'active' : '' }}" href="{{ route('about') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ABOUT UBU
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('about') }}"><i class="bi bi-info-circle me-2 text-muted"></i> Ubu Hospitality</a></li>
                                <li><a class="dropdown-item" href="{{ route('about') }}#company_story"><i class="bi bi-book me-2 text-muted"></i> Kisah Kami</a></li>
                                <li><a class="dropdown-item" href="{{ url('/#brands') }}"><i class="bi bi-collection me-2 text-muted"></i> Brand Kami</a></li>
                                <li><a class="dropdown-item" href="{{ route('about') }}#hospitality_standards"><i class="bi bi-shield-check me-2 text-muted"></i> Standar Hospitality</a></li>
                                <li><a class="dropdown-item" href="{{ route('life-at-ubu') }}"><i class="bi bi-heart me-2 text-muted"></i> Life at Ubu</a></li>
                                <li><a class="dropdown-item" href="{{ route('csr') }}"><i class="bi bi-tree me-2 text-muted"></i> CSR & Keberlanjutan</a></li>
                                <li><a class="dropdown-item" href="{{ route('career') }}"><i class="bi bi-briefcase me-2 text-muted"></i> Karir</a></li>
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
                            <a class="nav-link nav-link-ubu dropdown-toggle {{ request()->is('experience*') || request()->is('blog*') || request()->is('packages*') || request()->is('celebrity*') ? 'active' : '' }}" href="{{ route('experience.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                EXPERIENCE
                            </a>
                            <ul class="dropdown-menu border shadow-sm">
                                <li><a class="dropdown-item" href="{{ route('experience.index') }}"><i class="bi bi-stars me-2 text-muted"></i> Pengalaman Tambahan</a></li>
                                <li><a class="dropdown-item" href="{{ route('packages') }}"><i class="bi bi-box2-heart me-2 text-muted"></i> Paket Spesial Villa</a></li>
                                <li><a class="dropdown-item" href="{{ route('celebrity') }}"><i class="bi bi-award me-2 text-muted"></i> Celebrity Staycation</a></li>
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

    <!-- Modern Luxury Mobile Draw Menu (Offcanvas) -->
    <div class="offcanvas offcanvas-end mobile-draw-menu" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuOffcanvasLabel">
        <!-- Drawer Header -->
        <div class="offcanvas-header drawer-header">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/branding/logo-dark.svg') }}" alt="Ubu Hospitality Logo" height="34" class="d-inline-block">
                <div class="d-flex flex-column text-start">
                    <span class="drawer-brand-title" id="mobileMenuOffcanvasLabel">UBU HOSPITALITY</span>
                    <span class="drawer-brand-sub">LUXURY VILLAS & RESORTS</span>
                </div>
            </div>
            <button type="button" class="btn-drawer-close" data-bs-dismiss="offcanvas" aria-label="Tutup Menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Drawer Body -->
        <div class="offcanvas-body drawer-body">
            <!-- Quick Search Bar Card -->
            <a href="{{ route('stay.index') }}" class="drawer-search-card">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-search text-ubu-primary"></i>
                    <span class="small">Cari villa, resort, glamping...</span>
                </div>
                <span class="search-arrow"><i class="bi bi-arrow-right-short"></i></span>
            </a>

            <!-- Navigation Menu Items -->
            <div class="drawer-nav-list" id="mobileNavAccordion">
                <!-- 1. BERANDA -->
                <a href="{{ url('/') }}" class="drawer-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <span class="drawer-nav-icon"><i class="bi bi-house-door-fill"></i></span>
                    <span class="drawer-nav-label">Beranda</span>
                </a>

                <!-- 2. ABOUT UBU (Collapsible) -->
                <div class="drawer-nav-group">
                    <button class="drawer-nav-trigger {{ request()->is('about*') || request()->is('contact*') || request()->is('life-at-ubu*') || request()->is('csr*') || request()->is('career*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout" aria-expanded="{{ request()->is('about*') || request()->is('contact*') || request()->is('life-at-ubu*') || request()->is('csr*') || request()->is('career*') ? 'true' : 'false' }}">
                        <span class="drawer-nav-icon"><i class="bi bi-info-circle-fill"></i></span>
                        <span class="drawer-nav-label">About Ubu</span>
                        <i class="bi bi-chevron-down drawer-chevron"></i>
                    </button>
                    <div id="collapseAbout" class="collapse {{ request()->is('about*') || request()->is('contact*') || request()->is('life-at-ubu*') || request()->is('csr*') || request()->is('career*') ? 'show' : '' }}" data-bs-parent="#mobileNavAccordion">
                        <div class="drawer-subnav">
                            <a class="drawer-subnav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <span><i class="bi bi-dot"></i> Ubu Hospitality</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('about') }}#company_story">
                                <span><i class="bi bi-dot"></i> Kisah Kami</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ url('/#brands') }}">
                                <span><i class="bi bi-dot"></i> Brand Kami</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('about') }}#hospitality_standards">
                                <span><i class="bi bi-dot"></i> Standar Hospitality</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('life-at-ubu*') ? 'active' : '' }}" href="{{ route('life-at-ubu') }}">
                                <span><i class="bi bi-dot"></i> Life at Ubu</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('csr*') ? 'active' : '' }}" href="{{ route('csr') }}">
                                <span><i class="bi bi-dot"></i> CSR & Keberlanjutan</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('career*') ? 'active' : '' }}" href="{{ route('career') }}">
                                <span><i class="bi bi-dot"></i> Karir</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                                <span><i class="bi bi-dot"></i> Kontak</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. STAY & RESORT (Collapsible) -->
                <div class="drawer-nav-group">
                    <button class="drawer-nav-trigger {{ request()->is('stay*') || request()->is('brand*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStay" aria-expanded="{{ request()->is('stay*') || request()->is('brand*') ? 'true' : 'false' }}">
                        <span class="drawer-nav-icon"><i class="bi bi-building-fill"></i></span>
                        <span class="drawer-nav-label">Stay & Villa</span>
                        <i class="bi bi-chevron-down drawer-chevron"></i>
                    </button>
                    <div id="collapseStay" class="collapse {{ request()->is('stay*') || request()->is('brand*') ? 'show' : '' }}" data-bs-parent="#mobileNavAccordion">
                        <div class="drawer-subnav">
                            <a class="drawer-subnav-link {{ request()->is('brand/ubu-villa') ? 'active' : '' }}" href="{{ route('brand.show', 'ubu-villa') }}">
                                <span><i class="bi bi-dot"></i> Ubu Villa</span>
                                <span class="badge bg-light text-muted fw-normal" style="font-size: 0.65rem;">Private Pool</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('brand/buruj-villa') ? 'active' : '' }}" href="{{ route('brand.show', 'buruj-villa') }}">
                                <span><i class="bi bi-dot"></i> Buruj Villa</span>
                                <span class="badge bg-light text-muted fw-normal" style="font-size: 0.65rem;">Syariah</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('brand/ubu-glamping') ? 'active' : '' }}" href="{{ route('brand.show', 'ubu-glamping') }}">
                                <span><i class="bi bi-dot"></i> Ubu Glamping</span>
                                <span class="badge bg-light text-muted fw-normal" style="font-size: 0.65rem;">Nature</span>
                            </a>
                            <a class="drawer-subnav-link fw-semibold text-ubu-primary" href="{{ route('stay.index') }}">
                                <span><i class="bi bi-grid me-1"></i> Semua Properti & Resort</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. EXPERIENCE (Collapsible) -->
                <div class="drawer-nav-group">
                    <button class="drawer-nav-trigger {{ request()->is('experience*') || request()->is('blog*') || request()->is('packages*') || request()->is('celebrity*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExperience" aria-expanded="{{ request()->is('experience*') || request()->is('blog*') || request()->is('packages*') || request()->is('celebrity*') ? 'true' : 'false' }}">
                        <span class="drawer-nav-icon"><i class="bi bi-stars"></i></span>
                        <span class="drawer-nav-label">Experience</span>
                        <i class="bi bi-chevron-down drawer-chevron"></i>
                    </button>
                    <div id="collapseExperience" class="collapse {{ request()->is('experience*') || request()->is('blog*') || request()->is('packages*') || request()->is('celebrity*') ? 'show' : '' }}" data-bs-parent="#mobileNavAccordion">
                        <div class="drawer-subnav">
                            <a class="drawer-subnav-link {{ request()->is('experience') && !request()->has('category') ? 'active' : '' }}" href="{{ route('experience.index') }}">
                                <span><i class="bi bi-dot"></i> Pengalaman Tambahan</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('packages*') ? 'active' : '' }}" href="{{ route('packages') }}">
                                <span><i class="bi bi-dot"></i> Paket Spesial Villa</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('celebrity*') ? 'active' : '' }}" href="{{ route('celebrity') }}">
                                <span><i class="bi bi-dot"></i> Celebrity Staycation</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->get('category') === 'event' ? 'active' : '' }}" href="{{ route('experience.index', ['category' => 'event']) }}">
                                <span><i class="bi bi-dot"></i> Acara dan Pertemuan</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->get('category') === 'tour' ? 'active' : '' }}" href="{{ route('experience.index', ['category' => 'tour']) }}">
                                <span><i class="bi bi-dot"></i> Pengalaman Lokal</span>
                            </a>
                            <a class="drawer-subnav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                                <span><i class="bi bi-dot"></i> Panduan Perjalanan</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 5. OFFER & PROMO (Collapsible) -->
                <div class="drawer-nav-group">
                    <button class="drawer-nav-trigger {{ request()->is('offer*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOffer" aria-expanded="{{ request()->is('offer*') ? 'true' : 'false' }}">
                        <span class="drawer-nav-icon"><i class="bi bi-tag-fill"></i></span>
                        <span class="drawer-nav-label">Promo & Penawaran</span>
                        <i class="bi bi-chevron-down drawer-chevron"></i>
                    </button>
                    <div id="collapseOffer" class="collapse {{ request()->is('offer*') ? 'show' : '' }}" data-bs-parent="#mobileNavAccordion">
                        <div class="drawer-subnav">
                            <a class="drawer-subnav-link" href="{{ route('offer.index') }}">
                                <span><i class="bi bi-dot"></i> Promo Aktif</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('offer.index') }}#coupons">
                                <span><i class="bi bi-dot"></i> Promo Pengguna Baru</span>
                                <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.65rem;">15% OFF</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 6. PARTNERSHIP (Collapsible) -->
                <div class="drawer-nav-group">
                    <button class="drawer-nav-trigger {{ request()->is('partnership*') ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartnership" aria-expanded="{{ request()->is('partnership*') ? 'true' : 'false' }}">
                        <span class="drawer-nav-icon"><i class="bi bi-briefcase-fill"></i></span>
                        <span class="drawer-nav-label">Partnership</span>
                        <i class="bi bi-chevron-down drawer-chevron"></i>
                    </button>
                    <div id="collapsePartnership" class="collapse {{ request()->is('partnership*') ? 'show' : '' }}" data-bs-parent="#mobileNavAccordion">
                        <div class="drawer-subnav">
                            <a class="drawer-subnav-link" href="{{ route('partnership.index') }}">
                                <span><i class="bi bi-dot"></i> Pengelolaan Properti</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('partnership.index') }}#partnership_models">
                                <span><i class="bi bi-dot"></i> Model Kerja Sama</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('stay.index') }}">
                                <span><i class="bi bi-dot"></i> Portofolio</span>
                            </a>
                            <a class="drawer-subnav-link" href="{{ route('faq') }}">
                                <span><i class="bi bi-dot"></i> FAQ Pemilik</span>
                            </a>
                            <a class="drawer-subnav-link text-success fw-bold" href="{{ route('partnership.index') }}#submit">
                                <span><i class="bi bi-plus-circle me-1"></i> Ajukan Properti</span>
                                <span class="badge bg-success-subtle text-success fw-semibold" style="font-size: 0.65rem;">Gabung</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drawer Footer (Actions, Contacts, & Socials) -->
            <div class="drawer-footer">
                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                    <span class="text-muted small fw-medium">Pilihan Bahasa</span>
                    <div class="drawer-lang-toggle">
                        <a href="?lang=id" class="drawer-lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}">ID</a>
                        <a href="?lang=en" class="drawer-lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                    </div>
                </div>

                <!-- Cek Ketersediaan CTA Button -->
                <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary w-100 py-2.5 mb-2 rounded-3 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                    <i class="bi bi-calendar-check"></i> Cek Ketersediaan & Booking
                </a>

                <!-- WhatsApp Direct Support Button -->
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-drawer-wa w-100 py-2 mb-3 rounded-3 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-whatsapp fs-5"></i> Hubungi Customer Service
                </a>

                <!-- Social Links & Brand Tagline -->
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <a href="https://www.instagram.com/ubuvilla/" target="_blank" class="drawer-social-btn" title="Instagram" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@ubuvilla" target="_blank" class="drawer-social-btn" title="TikTok" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="https://www.youtube.com/@ubuvillaofficial" target="_blank" class="drawer-social-btn" title="YouTube" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="{{ $waUrl }}" target="_blank" class="drawer-social-btn" title="WhatsApp" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
                <p class="text-center text-muted mb-0" style="font-size: 0.7rem; letter-spacing: 0.5px;">Master of Warmth & Elegance in Yogyakarta</p>
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
                    <a href="{{ route('home') }}" class="d-inline-block mb-3" aria-label="Ubu Hospitality">
                        <img src="{{ asset('images/branding/logo-light.png') }}" alt="Ubu Hospitality Logo" height="85" class="footer-logo mb-1">
                    </a>
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
                        <a href="{{ \App\Models\Setting::get('social_whatsapp', 'https://api.whatsapp.com/send?phone=+6282320003297') }}" target="_blank" class="btn footer-social-btn" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_instagram', 'https://www.instagram.com/ubuvilla/') }}" target="_blank" class="btn footer-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_tiktok', 'https://www.tiktok.com/@ubuvilla') }}" target="_blank" class="btn footer-social-btn" title="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_youtube', 'https://www.youtube.com/@ubuvillaindonesia') }}" target="_blank" class="btn footer-social-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_facebook', 'https://www.facebook.com/ubuvillaindonesia/') }}" target="_blank" class="btn footer-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
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

            <!-- Partner Pembayaran (Official Payment Partners) -->
            <div class="footer-payment-section py-4 my-3 border-top border-bottom" style="border-color: rgba(255,255,255,0.12) !important;">
                <div class="row align-items-center g-3">
                    <div class="col-lg-3 text-center text-lg-start">
                        <span class="text-white-50 text-uppercase fw-semibold small" style="letter-spacing: 1.2px; font-size: 0.75rem;">Partner Pembayaran Resmi</span>
                        <div class="text-white fw-bold small mt-1">Pembayaran Aman & Terverifikasi</div>
                    </div>
                    <div class="col-lg-9">
                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end align-items-center gap-2">
                            @php
                                $paymentIcons = [
                                    ['name' => 'BCA', 'file' => 'bca.webp'],
                                    ['name' => 'BNI', 'file' => 'bni.webp'],
                                    ['name' => 'Mandiri', 'file' => 'mandiri.webp'],
                                    ['name' => 'BRI', 'file' => 'bri.webp'],
                                    ['name' => 'BRIVA', 'file' => 'briva.webp'],
                                    ['name' => 'Mastercard', 'file' => 'mastercard.webp'],
                                    ['name' => 'AMEX', 'file' => 'american.webp'],
                                    ['name' => 'ATM Bersama', 'file' => 'atm.webp'],
                                    ['name' => 'Prima', 'file' => 'prima.webp'],
                                    ['name' => 'LinkAja', 'file' => 'link.webp'],
                                    ['name' => 'Indomaret', 'file' => 'indomaret.webp'],
                                    ['name' => 'Alfamart', 'file' => 'alfamart.webp'],
                                ];
                            @endphp
                            @foreach($paymentIcons as $partner)
                                <div class="bg-white rounded px-2 py-1 shadow-sm d-flex align-items-center justify-content-center" style="height: 36px; min-width: 58px;" title="{{ $partner['name'] }}">
                                    <img src="{{ asset('images/payments/' . $partner['file']) }}" alt="{{ $partner['name'] }}" style="max-height: 24px; max-width: 50px; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>
                    </div>
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
                confirmButtonColor: '#0085a2',
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
                confirmButtonColor: '#f1c40f'
            });
        @endif
    </script>

    <!-- Global image fallback: kosong / rusak -> default-img.png -->
    <script>
        window.DEFAULT_IMG = "{{ asset('images/default-img.png') }}";
        document.addEventListener('error', function (e) {
            var t = e.target;
            if (t && t.tagName === 'IMG' && !t.dataset.fallbackApplied) {
                t.dataset.fallbackApplied = '1';
                t.src = window.DEFAULT_IMG;
            }
        }, true);
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('img').forEach(function (img) {
                var src = (img.getAttribute('src') || '').trim();
                if (src === '') {
                    img.src = window.DEFAULT_IMG;
                }
        });

        // Auto-close Mobile Draw Menu when navigating via hash anchors
        document.addEventListener('DOMContentLoaded', function () {
            var offcanvasEl = document.getElementById('mobileMenuOffcanvas');
            if (offcanvasEl && typeof bootstrap !== 'undefined') {
                offcanvasEl.querySelectorAll('a[href*="#"]').forEach(function(link) {
                    link.addEventListener('click', function() {
                        var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                        if (bsOffcanvas) {
                            bsOffcanvas.hide();
                        }
                    });
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
