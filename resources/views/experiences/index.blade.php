@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                @if(isset($activeCategoryTitle))
                    <li class="breadcrumb-item"><a href="{{ route('experience.index') }}" class="text-decoration-none text-muted">Experience</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $activeCategoryTitle }}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">Experience & Aktivitas</li>
                @endif
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">
            {{ $activeCategoryTitle ?? 'Pengalaman & Aktivitas Menarik' }}
        </h1>
        <p class="text-muted small mb-3">
            @if(isset($category) && $category === 'event')
                Paket intimate wedding, private celebration party, gathering perusahaan, dan arisan keluarga di villa privat Yogyakarta.
            @elseif(isset($category) && $category === 'tour')
                Petualangan seru Merapi lava tour jeep, sunrise tour, dan eksplorasi keindahan alam otentik Yogyakarta.
            @else
                Lengkapi waktu santai Anda di Yogyakarta dengan ragam aktivitas khas dan momen berharga bersama orang tercinta.
            @endif
        </p>

        <!-- Category Filter Tabs -->
        <div class="d-flex flex-wrap gap-2 pt-2">
            <a href="{{ route('experience.index') }}" class="filter-pill {{ empty($category) ? 'active' : '' }}">
                Semua Aktivitas
            </a>
            <a href="{{ route('experience.index', ['category' => 'event']) }}" class="filter-pill {{ ($category ?? '') === 'event' ? 'active' : '' }}">
                <i class="bi bi-people"></i> Acara & Pertemuan
            </a>
            <a href="{{ route('experience.index', ['category' => 'tour']) }}" class="filter-pill {{ ($category ?? '') === 'tour' ? 'active' : '' }}">
                <i class="bi bi-compass"></i> Pengalaman Lokal & Tur
            </a>
            <a href="{{ route('experience.index', ['category' => 'culinary']) }}" class="filter-pill {{ ($category ?? '') === 'culinary' ? 'active' : '' }}">
                <i class="bi bi-egg-fried"></i> Kuliner & BBQ
            </a>
            <a href="{{ route('experience.index', ['category' => 'wellness']) }}" class="filter-pill {{ ($category ?? '') === 'wellness' ? 'active' : '' }}">
                <i class="bi bi-flower1"></i> Wellness & Spa
            </a>
            <a href="{{ route('experience.index', ['category' => 'service']) }}" class="filter-pill {{ ($category ?? '') === 'service' ? 'active' : '' }}">
                <i class="bi bi-camera"></i> Layanan Tambahan
            </a>
        </div>
    </div>
</div>

<div class="container py-5">
    @if($experiences->isEmpty())
        <x-empty-state
            icon="bi-compass"
            title="Belum Ada Aktivitas Terdaftar"
            message="Koleksi aktivitas sedang dalam proses kurasi."
        />
    @else
        <div class="row g-4">
            @foreach($experiences as $exp)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card">
                        <div style="aspect-ratio: 16 / 10; overflow: hidden; position: relative;">
                            <x-fallback-image :src="$exp->featured_image_url" alt="{{ $exp->title }}" class="w-100 h-100 object-fit-cover" loading="lazy" />
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
    @endif
</div>
@endsection
