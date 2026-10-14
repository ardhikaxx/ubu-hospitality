@extends('layouts.public')

@section('content')
<!-- Hero Header -->
<div class="py-5 text-white" style="background-color: var(--ubu-primary, #0085a2);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Celebrity & Public Figures</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">Review & Highlight</span>
        <h1 class="font-serif display-5 fw-bold mb-3 text-white">Celebrity Staycation at Ubu Villa</h1>
        <p class="lead text-white max-w-2xl mb-0" style="max-width: 720px; opacity: 0.95;">
            Melihat momen kehangatan, kenyamanan, dan pengalaman istimewa para figur publik, selebriti ternama, dan konten kreator saat menikmati staycation privat di villa Ubu Hospitality.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Featured Celebrity Story -->
    <div class="row g-4 align-items-center mb-5">
        <div class="col-lg-7">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border">
                <img src="{{ asset('images/celebrity/verrel-bramasta.jpg') }}" alt="Verrel Bramasta Staycation" class="w-100 object-fit-cover" style="min-height: 400px; max-height: 480px;">
                <div class="position-absolute top-0 start-0 m-3">
                    <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill"><i class="bi bi-star-fill text-warning me-1"></i> Featured Stay</span>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ps-lg-3">
                <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 1.5px; color: #0085a2 !important;">Exclusive Experience</span>
                <h2 class="font-serif fw-bold text-dark mt-2 mb-3">Staycation Bersama Nagisa Bali: Verrel Bramasta Stay At Villa NVL Canggu</h2>
                <p class="text-secondary" style="line-height: 1.8;">
                    Aktor dan figur publik ternama Verrel Bramasta kembali mempercayakan momen liburan santai dan staycation privat bersama keluarga dan sahabat. Privasi maksimal, layanan butler hangat, dan suasana eksklusif menjadi alasan utama memilih jaringan hospitality kami.
                </p>
                <div class="d-flex align-items-center gap-3 py-3 border-top border-bottom my-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-quote fs-3" style="color: #0085a2;"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">Verrel Bramasta</div>
                        <small class="text-muted">Aktor & Public Figure Indonesia</small>
                    </div>
                </div>
                <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary px-4 py-2 rounded-pill">
                    <i class="bi bi-calendar-check me-2"></i> Rasakan Pengalaman Serupa
                </a>
            </div>
        </div>
    </div>

    <!-- Celebrity & Influencer Grid Gallery -->
    <div class="pt-4 border-top">
        <div class="text-center mb-5">
            <h3 class="font-serif fw-bold text-dark">Galeri Staycation Figur Publik</h3>
            <p class="text-muted">Setiap momen dirancang untuk memberikan privasi total dan relaksasi tanpa batas.</p>
        </div>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('images/celebrity/verrel-bramasta.jpg') }}" class="card-img-top object-fit-cover" style="height: 240px;" alt="Private Sanctuary">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-light text-dark border">Celebrity Holiday</span>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> Verified Stay</small>
                        </div>
                        <h5 class="card-title font-serif fw-bold text-dark">Relaksasi Privat Tanpa Gangguan</h5>
                        <p class="card-text text-secondary small" style="line-height: 1.7;">
                            Menghabiskan waktu santai di private pool dengan pemandangan terbuka dan ketenangan yang menyejukkan pikiran dari padatnya jadwal syuting.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('images/branding/hero-bg.webp') }}" class="card-img-top object-fit-cover" style="height: 240px;" alt="VIP Butler Service">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-light text-dark border">VIP Hospitality</span>
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> Dedicated Butler</small>
                        </div>
                        <h5 class="card-title font-serif fw-bold text-dark">Layanan Butler Khusus 24 Jam</h5>
                        <p class="card-text text-secondary small" style="line-height: 1.7;">
                            Mulai dari penyajian Floating Breakfast tropis, In-Villa BBQ malam hari, hingga kebersihan higienis standar hotel bintang 5.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ asset('images/celebrity/katalog-6.jpg') }}" class="card-img-top object-fit-cover" style="height: 240px;" alt="Content Creation Space">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-light text-dark border">Aesthetic Ambience</span>
                            <small class="text-muted"><i class="bi bi-camera me-1"></i> Photo & Video</small>
                        </div>
                        <h5 class="card-title font-serif fw-bold text-dark">Spot Foto & Konten Estetik</h5>
                        <p class="card-text text-secondary small" style="line-height: 1.7;">
                            Setiap sudut arsitektur villa mengusung estetika tropical luxury yang fotogenik, sangat cocok untuk pembuatan konten digital berkualitas tinggi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking CTA Banner -->
    <div class="mt-5 p-5 rounded-4 text-white text-center position-relative overflow-hidden" style="background-color: var(--ubu-primary, #0085a2);">
        <h3 class="font-serif fw-bold mb-2 text-white">Rencanakan Staycation Eksklusif Anda</h3>
        <p class="text-white mb-4 max-w-xl mx-auto" style="max-width: 600px; opacity: 0.95;">
            Dapatkan pengalaman menginap berkelas selebriti dengan kenyamanan private villa dan keramahan khas Ubu Hospitality di Yogyakarta & Bali.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('stay.index') }}" class="btn btn-ubu-gold btn-lg px-4 py-2 rounded-pill shadow-lg">
                <i class="bi bi-search me-1"></i> Pilih Villa Anda
            </a>
            <a href="{{ \App\Models\Setting::get('contact_whatsapp_url', 'https://api.whatsapp.com/send?phone=+6282320003297') }}" target="_blank" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill">
                <i class="bi bi-whatsapp me-1"></i> Tanya Reservasi VIP
            </a>
        </div>
    </div>
</div>
@endsection
