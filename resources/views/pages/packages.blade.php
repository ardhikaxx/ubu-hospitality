@extends('layouts.public')

@section('content')
<!-- Hero Header -->
<div class="py-5 text-white" style="background-color: var(--ubu-primary, #0085a2);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Packages</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">Special Packages</span>
        <h1 class="font-serif display-5 fw-bold mb-3 text-white">Paket Wisata & Layanan Tambahan Villa</h1>
        <p class="lead text-white max-w-2xl mb-0" style="max-width: 720px; opacity: 0.95;">
            Lengkapi momen staycation Anda dengan beragam paket pengalaman istimewa—mulai dari floating breakfast di kolam renang privat, hidangan In-Villa BBQ, hingga petualangan Lava Tour Merapi.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Featured Packages Overview -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #e6f6f9; color: #0085a2;">
                    <i class="bi bi-cup-hot-fill fs-3"></i>
                </div>
                <h5 class="font-serif fw-bold text-dark">Floating Breakfast</h5>
                <p class="text-secondary small mb-0">Nikmati sarapan pagi mewah mengapung di kolam renang privat dengan menu lezat dan buah tropis segar.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #fff9e6; color: #f1c40f;">
                    <i class="bi bi-fire fs-3"></i>
                </div>
                <h5 class="font-serif fw-bold text-dark">In-Villa BBQ Night</h5>
                <p class="text-secondary small mb-0">Pesta barbeque privat di tepi kolam bersama keluarga dan sahabat dengan peralatan dan bahan premium lengkap.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #e6f6f9; color: #006771;">
                    <i class="bi bi-compass-fill fs-3"></i>
                </div>
                <h5 class="font-serif fw-bold text-dark">Lava Tour Merapi</h5>
                <p class="text-secondary small mb-0">Petualangan jeep off-road menyusuri lereng Gunung Merapi dengan pemandangan menakjubkan dan pemandu berpengalaman.</p>
            </div>
        </div>
    </div>

    <!-- Experience List from Database -->
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="font-serif fw-bold text-dark mb-1">Daftar Paket & Pengalaman Tersedia</h3>
            <p class="text-muted small mb-0">Pilih paket pelengkap untuk ditambahkan ke reservasi villa Anda.</p>
        </div>
    </div>

    @if(isset($experiences) && $experiences->isNotEmpty())
        <div class="row g-4">
            @foreach($experiences as $exp)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                        <x-fallback-image :src="$exp->featured_image_url" alt="{{ $exp->title }}" class="card-img-top object-fit-cover" style="height: 220px;" loading="lazy" />

                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 text-white px-3 py-1 rounded-pill small">
                                {{ ucfirst($exp->category ?? 'Paket') }}
                            </span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title font-serif fw-bold text-dark mb-2">{{ $exp->title }}</h5>
                                <p class="card-text text-secondary small mb-3" style="line-height: 1.6;">
                                    {{ Str::limit(strip_tags($exp->description ?? $exp->short_description ?? ''), 120) }}
                                </p>
                            </div>

                            <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai dari</small>
                                    <span class="fw-bold" style="color: #0085a2; font-size: 1.05rem;">
                                        {{ $exp->price_display ?? 'Hubungi Kami' }}
                                    </span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('experience.show', $exp->slug) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2">
                                        Detail
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo Ubu Hospitality, saya tertarik memesan paket: ' . $exp->title) }}" target="_blank" class="btn btn-sm btn-ubu-primary rounded-pill px-3">
                                        <i class="bi bi-whatsapp me-1"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 bg-light rounded-4">
            <i class="bi bi-stars text-muted fs-1 mb-2 d-block"></i>
            <h5 class="text-muted">Paket sedang diperbarui</h5>
            <p class="text-secondary small">Silakan hubungi WhatsApp kami untuk kustomisasi paket menginap khusus.</p>
            <a href="https://api.whatsapp.com/send?phone=6282320003297" target="_blank" class="btn btn-ubu-primary rounded-pill px-4">Hubungi Tim Reservasi</a>
        </div>
    @endif

    <!-- In-Villa Request Notice -->
    <div class="mt-5 p-4 rounded-4 border bg-white shadow-sm d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                <i class="bi bi-gift fs-4" style="color: #0085a2;"></i>
            </div>
            <div>
                <h6 class="fw-bold text-dark mb-1">Punya Permintaan Khusus atau Acara Kejutan?</h6>
                <p class="text-muted small mb-0">Tim butler kami siap membantu dekorasi ulang tahun, honeymoon setup, atau gathering keluarga.</p>
            </div>
        </div>
        <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo Ubu Hospitality, saya ingin konsultasi paket custom / special request untuk villa.') }}" target="_blank" class="btn btn-outline-dark rounded-pill px-4 text-nowrap">
            Konsultasi Gratis
        </a>
    </div>
</div>
@endsection
