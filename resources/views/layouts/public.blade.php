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
                <!-- Brand Logo -->
                <a class="navbar-brand navbar-brand-logo" href="{{ url('/') }}">
                    <span class="navbar-brand-title">UBU HOSPITALITY</span>
                    <span class="navbar-brand-sub">ASSET MANAGEMENT</span>
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

                <!-- Desktop Nav Items -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                    <ul class="navbar-nav align-items-center gap-1 me-3">
                        @foreach($headerItems as $item)
                            <li class="nav-item">
                                <a class="nav-link nav-link-ubu {{ request()->is(ltrim($item->url, '/').'*') ? 'active' : '' }}" href="{{ url($item->url) }}">
                                    {{ $item->title }}
                                </a>
                            </li>
                        @endforeach

                        <!-- Brand Dropdown -->
                        @if(isset($navBrands) && $navBrands->isNotEmpty())
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-ubu dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    BRANDS
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 p-2">
                                    @foreach($navBrands as $b)
                                        <li>
                                            <a class="dropdown-item py-2 px-3 rounded-2 fw-medium" href="{{ route('brand.show', $b->slug) }}">
                                                <div class="fw-bold text-dark">{{ $b->name }}</div>
                                                <small class="text-muted">{{ $b->tagline }}</small>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>

                    <!-- Language & Actions -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Language Toggle -->
                        <div class="btn-group btn-group-sm border rounded-pill p-1 bg-light">
                            <a href="?lang=id" class="btn btn-sm rounded-pill py-0 px-2 {{ app()->getLocale() === 'id' ? 'btn-white bg-white fw-bold shadow-sm text-dark' : 'text-muted border-0' }}">ID</a>
                            <a href="?lang=en" class="btn btn-sm rounded-pill py-0 px-2 {{ app()->getLocale() === 'en' ? 'btn-white bg-white fw-bold shadow-sm text-dark' : 'text-muted border-0' }}">EN</a>
                        </div>

                        <!-- Check Availability CTA -->
                        <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary btn-sm px-3 ms-2">
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
                <ul class="nav flex-column gap-2 mb-4">
                    @foreach($headerItems as $item)
                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-semibold text-dark px-0 py-2" href="{{ url($item->url) }}">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if(isset($navBrands) && $navBrands->isNotEmpty())
                    <h6 class="text-uppercase small fw-bold text-muted mb-2">Our Brands</h6>
                    <div class="list-group list-group-flush mb-4">
                        @foreach($navBrands as $b)
                            <a href="{{ route('brand.show', $b->slug) }}" class="list-group-item list-group-item-action px-0 py-2 border-0">
                                <div class="fw-bold">{{ $b->name }}</div>
                                <small class="text-muted">{{ $b->tagline }}</small>
                            </a>
                        @endforeach
                    </div>
                @endif
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
                <!-- Col 1: Brand Info -->
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-white font-serif mb-2">UBU HOSPITALITY</h4>
                    <p class="text-white small mb-3">
                        Perusahaan manajemen aset hospitality terkemuka di Indonesia yang mengelola portfolio villa privat, akomodasi syariah terpercaya, dan glamping berkarakter.
                    </p>
                    <p class="small text-white mb-1">
                        <i class="bi bi-geo-alt text-warning me-1"></i> {{ \App\Models\Setting::get('contact_address', 'Jl. Gito Gati No. 88, Sariharjo, Ngaglik, Sleman, D.I. Yogyakarta 55581') }}
                    </p>
                    <p class="small text-white mb-1">
                        <i class="bi bi-telephone text-warning me-1"></i> {{ \App\Models\Setting::get('contact_phone', '(0274) 889977') }}
                    </p>
                    <p class="small text-white mb-3">
                        <i class="bi bi-envelope text-warning me-1"></i> {{ \App\Models\Setting::get('contact_email', 'reservation@ubuhospitality.com') }}
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ \App\Models\Setting::get('social_instagram', 'https://instagram.com') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;"><i class="bi bi-instagram"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_tiktok', 'https://tiktok.com') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;"><i class="bi bi-tiktok"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_youtube', 'https://youtube.com') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;"><i class="bi bi-youtube"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_linkedin', 'https://linkedin.com') }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle p-2" style="width: 36px; height: 36px;"><i class="bi bi-linkedin"></i></a>
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
