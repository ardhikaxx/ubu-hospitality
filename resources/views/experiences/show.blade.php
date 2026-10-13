@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('experience.index') }}" class="text-decoration-none text-muted">Experience</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $experience->title }}</li>
            </ol>
        </nav>
        <span class="badge bg-dark rounded-pill px-3 py-1 mb-2">{{ ucfirst($experience->category) }}</span>
        <h1 class="font-serif fw-bold text-dark mb-1">{{ $experience->title }}</h1>
        <p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $experience->location ?: 'Yogyakarta' }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="aspect-ratio: 16 / 9;">
                <img src="{{ $experience->featured_image }}" alt="{{ $experience->title }}" class="w-100 h-100 object-fit-cover">
            </div>

            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h4 class="font-serif fw-bold text-dark mb-3">Rincian Pengalaman</h4>
                <div class="text-secondary" style="line-height: 1.8;">
                    {!! nl2br(e($experience->content ?: $experience->short_description)) !!}
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-md bg-white position-sticky" style="top: 90px;">
                <div class="small text-muted mb-1">Perkiraan Biaya</div>
                <div class="fs-4 fw-bold text-success mb-3">{{ $experience->price_display }}</div>

                <p class="small text-muted mb-4">
                    Aktivitas ini dapat ditambahkan saat pemesanan villa Anda atau dipesan langsung melalui butler dan customer care kami.
                </p>

                <a href="https://wa.me/6281234567890?text=Halo%20Ubu%20Hospitality%2C%20saya%20tertarik%20dengan%20aktivitas%20{{ urlencode($experience->title) }}"
                   target="_blank"
                   class="btn btn-ubu-primary w-100 py-3 fw-bold mb-2">
                    <i class="bi bi-whatsapp me-1"></i> Pesan via WhatsApp CS
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
