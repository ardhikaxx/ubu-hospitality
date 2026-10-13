@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-center py-5">
        <span class="badge bg-white text-dark rounded-pill px-3 py-2 fw-semibold mb-3 shadow-sm">
            <i class="bi bi-geo-alt-fill text-danger me-1"></i> Yogyakarta, Indonesia
        </span>
        <h1 class="hero-title serif-font">
            Satu Induk Beragam Pesona,<br>Kenyamanan Privat Tanpa Kompromi
        </h1>
        <p class="hero-subtitle mx-auto">
            Ubu Hospitality menaungi koleksi villa mewah privat dan akomodasi syariah terpercaya di Yogyakarta. Rasakan kehangatan layanan autentik nusantara.
        </p>

        <!-- Accommodation Search Widget -->
        <div class="max-w-4xl mx-auto mt-4 text-start" style="max-width: 980px;">
            <x-search-widget />
        </div>
    </div>
</section>

<!-- Spacer for search widget overlap -->
<div style="height: 4rem;"></div>

<!-- Active Promotions Section (Traveloka-inspired clarity) -->
@if(isset($activePromos) && $activePromos->isNotEmpty())
<section class="section-padding bg-white">
    <div class="container">
        <x-section-header
            pill="Penawaran Eksklusif"
            title="Promo Istimewa Menginap Lebih Hemat"
            desc="Gunakan kode promo resmi untuk mendapatkan penawaran harga terbaik langsung melalui pemesanan resmi."
            actionText="Lihat Semua Promo"
            actionUrl="{{ route('offer.index') }}"
        />

        <div class="row g-4">
            @foreach($activePromos as $promo)
                <div class="col-lg-4 col-md-6">
                    <x-promo-card :promotion="$promo" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Master Brands Showcase (Multi-brand architecture) -->
<section class="section-padding" style="background-color: var(--ubu-bg-alt);">
    <div class="container">
        <x-section-header
            pill="Multi-Brand Portfolio"
            title="Brand Hospitality Dalam Naungan Kami"
            desc="Dari oase privat modern hingga peristirahatan keluarga berprinsip syariah murni, temukan kenyamanan yang sesuai dengan kebutuhan Anda."
            center="true"
        />

        <div class="row g-4 justify-content-center">
            @foreach($brands as $brand)
                <div class="col-lg-4 col-md-6">
                    <x-brand-card :brand="$brand" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Properties Section -->
<section class="section-padding bg-white">
    <div class="container">
        <x-section-header
            pill="Pilihan Unggulan"
            title="Properti Terfavorit Tamu Kami"
            desc="Koleksi villa dengan rating tertinggi, fasilitas private pool eksklusif, dan suasana lingkungan yang menenangkan."
            actionText="Lihat Semua Properti"
            actionUrl="{{ route('stay.index') }}"
        />

        <div class="row g-4">
            @foreach($featuredProperties as $prop)
                <div class="col-lg-4 col-md-6">
                    <x-property-card :property="$prop" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Explore by Destinations -->
<section class="section-padding" style="background-color: var(--ubu-bg-alt);">
    <div class="container">
        <x-section-header
            pill="Jelajahi Lokasi"
            title="Destinasi Terbaik di Yogyakarta"
            desc="Pilih kawasan favorit Anda mulai dari suasana sejuk lereng Kaliurang hingga ketenangan asri di Sleman dan Bantul."
            center="true"
        />

        <div class="row g-4">
            @foreach($destinations as $dest)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('stay.index', ['city' => $dest->name]) }}" class="text-decoration-none text-dark">
                        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card">
                            <div style="aspect-ratio: 4 / 3; overflow: hidden; position: relative;">
                                <img src="{{ $dest->image_path ?: 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=600&q=80' }}"
                                     alt="{{ $dest->name }}"
                                     class="w-100 h-100 object-fit-cover"
                                     style="transition: transform 0.4s ease;"
                                     loading="lazy">
                                <div class="position-absolute inset-0 bg-dark opacity-25"></div>
                                <div class="position-absolute bottom-0 start-0 p-3 text-white">
                                    <h4 class="font-serif fw-bold mb-0 text-white">{{ $dest->name }}</h4>
                                    <small class="text-white-50">{{ $dest->properties_count }} Properti</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Signature Experiences -->
@if(isset($experiences) && $experiences->isNotEmpty())
<section class="section-padding bg-white">
    <div class="container">
        <x-section-header
            pill="Aktivitas & Momen"
            title="Pengalaman Istimewa Selama Menginap"
            desc="Lengkapi hari libur Anda dengan sarapan terapung di kolam renang privat, petualangan jeep Merapi, dan makan malam BBQ pribadi."
            actionText="Lihat Semua Pengalaman"
            actionUrl="{{ route('experience.index') }}"
        />

        <div class="row g-4">
            @foreach($experiences as $exp)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card">
                        <div style="aspect-ratio: 16 / 10; overflow: hidden; position: relative;">
                            <img src="{{ $exp->featured_image }}" alt="{{ $exp->title }}" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">
                                {{ ucfirst($exp->category) }}
                            </span>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h4 class="font-serif fs-5 fw-bold text-dark mb-2">{{ $exp->title }}</h4>
                            <p class="small text-muted mb-3 flex-grow-1">{{ $exp->short_description }}</p>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <span class="fw-bold text-success small">{{ $exp->price_display }}</span>
                                <a href="{{ route('experience.show', $exp->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Partnership Call to Action Banner (RedDoorz-inspired clarity) -->
<section class="py-5" style="background: linear-gradient(135deg, #16201b 0%, #1b3b2b 100%); color: #ffffff;">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark fw-bold text-uppercase px-3 py-1 mb-2">Peluang Kemitraan</span>
                <h2 class="font-serif display-6 fw-bold text-white mb-2">Miliki Villa atau Tanah di Yogyakarta?</h2>
                <p class="text-white-50 fs-6 mb-0">
                    Percayakan pengelolaan properti Anda kepada Ubu Hospitality. Kami menangani operasional harian, pemasaran digital terintegrasi, pemeliharaan standar kebersihan bintang lima, serta laporan finansial transparan.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('partnership.index') }}" class="btn btn-ubu-accent btn-lg px-4 py-3 shadow">
                    <i class="bi bi-building-up me-2"></i> Ajukan Properti Anda
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Curated 5-Star Google Guest Reviews -->
@if(isset($reviews) && $reviews->isNotEmpty())
<section class="section-padding" style="background-color: var(--ubu-bg-alt);">
    <div class="container">
        <x-section-header
            pill="Ulasan Tamu Nyata"
            title="Apa Kata Tamu Yang Telah Menginap"
            desc="Transparansi ulasan bintang lima dari tamu terverifikasi Google Maps mengenai kenyamanan, privasi kolam renang, dan pelayanan kami."
            center="true"
        />

        <div class="row g-4">
            @foreach($reviews as $rev)
                <div class="col-lg-3 col-md-6">
                    <x-review-card :review="$rev" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Travel Inspiration & Latest Blog -->
@if(isset($latestPosts) && $latestPosts->isNotEmpty())
<section class="section-padding bg-white">
    <div class="container">
        <x-section-header
            pill="Inspirasi Liburan"
            title="Tips & Cerita Perjalanan Terbaru"
            desc="Rekomendasi destinasi tersembunyi di Jogja, panduan liburan keluarga, dan inspirasi staycation syariah."
            actionText="Baca Seluruh Artikel"
            actionUrl="{{ route('blog.index') }}"
        />

        <div class="row g-4">
            @foreach($latestPosts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card">
                        <div style="aspect-ratio: 16 / 10; overflow: hidden;">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                <span class="badge bg-light text-dark border">{{ $post->category?->name }}</span>
                                <span>&bull; {{ $post->reading_time_minutes }} menit baca</span>
                            </div>
                            <h4 class="font-serif fs-5 fw-bold text-dark mb-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <p class="small text-muted mb-3 flex-grow-1">{{ $post->excerpt }}</p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-link text-success p-0 fw-bold text-decoration-none mt-auto">
                                Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
