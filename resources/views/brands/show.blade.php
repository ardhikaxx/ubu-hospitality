@extends('layouts.public')

@section('content')
<!-- Brand Hero Cover -->
<section class="position-relative text-white py-5" style="background-color: {{ $brand->accent_color ?: '#0085a2' }}; min-height: 340px; display: flex; align-items: center;">
    <div class="position-absolute inset-0 opacity-25" style="background-image: url('{{ image_or_default($brand->cover_image_path) }}'); background-size: cover; background-position: center;"></div>
    <div class="container position-relative z-2 py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stay.index') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Brands</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $brand->name }}</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-3 mb-2">
            <h1 class="font-serif display-4 fw-bold text-white mb-0">{{ $brand->name }}</h1>
            @if($brand->positioning_type === 'syariah')
                <span class="badge-syariah fs-6 px-3 py-2"><i class="bi bi-shield-check"></i> Syariah Compliant</span>
            @endif
        </div>
        <p class="fs-5 text-white max-w-2xl mb-0" style="max-width: 680px; opacity: 0.95;">{{ $brand->tagline }}</p>
    </div>
</section>

<div class="container py-5">
    <!-- Brand Story & Pillars -->
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="section-pill" style="color: {{ $brand->accent_color }}; background: {{ $brand->accent_color }}15;">
                Filosofi & Nilai Brand
            </span>
            <h2 class="font-serif fw-bold text-dark mb-3">{{ $brand->name }}</h2>
            <div class="text-secondary mb-4" style="line-height: 1.8;">
                {!! nl2br(e($brand->story ?: $brand->description)) !!}
            </div>

            @if(!empty($brand->character_highlights))
                <h5 class="fw-bold text-dark mb-3">Standar Kualitas & Karakter:</h5>
                <ul class="list-unstyled">
                    @foreach($brand->character_highlights as $highlight)
                        <li class="d-flex align-items-start gap-2 mb-2 text-dark">
                            <i class="bi bi-patch-check-fill mt-1" style="color: {{ $brand->accent_color ?: '#0085a2' }};"></i>
                            <span>{{ $highlight }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-lg-6">
            <div class="rounded-4 overflow-hidden shadow-lg" style="aspect-ratio: 16 / 11;">
                <x-fallback-image :src="$brand->cover_image_path" alt="{{ $brand->name }}" class="w-100 h-100 object-fit-cover" />
            </div>
        </div>
    </div>

    <!-- Properties under this Brand -->
    <div class="pt-4 border-top">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <span class="section-pill" style="color: {{ $brand->accent_color }}; background: {{ $brand->accent_color }}15;">Katalog Properti</span>
                <h2 class="font-serif fw-bold text-dark mb-0">Pilihan Properti {{ $brand->name }}</h2>
            </div>
            <span class="text-muted small">Total {{ $properties->total() }} Properti</span>
        </div>

        @if($properties->isEmpty())
            <x-empty-state
                icon="bi-building-x"
                title="Belum Ada Properti Terdaftar"
                message="Properti untuk brand ini sedang dalam proses kurasi dan persiapan publikasi."
                :actionUrl="route('stay.index')"
                actionText="Lihat Brand Lainnya"
            />
        @else
            <div class="row g-4">
                @foreach($properties as $prop)
                    <div class="col-md-6 col-lg-4">
                        <x-property-card :property="$prop" />
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $properties->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Brand Guest Reviews -->
    @if($reviews->isNotEmpty())
        <div class="mt-5 pt-5 border-top">
            <div class="text-center mb-4">
                <span class="section-pill">Ulasan Tamu</span>
                <h3 class="font-serif fw-bold text-dark">Pengalaman Menginap di {{ $brand->name }}</h3>
            </div>
            <div class="row g-4">
                @foreach($reviews as $rev)
                    <div class="col-md-4">
                        <x-review-card :review="$rev" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
