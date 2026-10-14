@extends('layouts.public')

@section('content')
<!-- Hero Header -->
<div class="py-5 text-white" style="background-color: var(--ubu-primary, #0085a2);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('about') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Tentang Kami</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Life at Ubu</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">Culture & Warmth</span>
        <h1 class="font-serif display-5 fw-bold mb-3 text-white">Life at Ubu Hospitality</h1>
        <p class="lead text-white max-w-2xl mb-0" style="max-width: 720px; opacity: 0.95;">
            Mengenal lebih dekat dedikasi, kehangatan budaya lokal, dan standar pelayanan butler profesional di balik setiap senyuman dan kenyamanan menginap tamu Ubu Hospitality.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Story & Core Philosophy -->
    <div class="row g-4 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="text-uppercase fw-bold small" style="letter-spacing: 1.5px; color: #0085a2;">Filosofi Pelayanan</span>
            <h2 class="font-serif fw-bold text-dark mt-2 mb-3">Master of Warmth: Sentuhan Ketulusan di Setiap Momen</h2>
            <p class="text-secondary" style="line-height: 1.8;">
                Di Ubu Hospitality, kami meyakini bahwa kemewahan sejati bukan hanya terletak pada arsitektur bangunan villa yang megah dan kolam renang privat yang jernih, melainkan pada <strong>kehangatan pelayanan yang tulus (sincere hospitality)</strong>.
            </p>
            <p class="text-secondary" style="line-height: 1.8;">
                Setiap anggota tim kami, mulai dari butler pribadi, tim housekeeping, hingga customer experience representative, dilatih untuk memahami kebutuhan setiap tamu dengan empati dan perhatian detail layaknya menyambut keluarga sendiri di rumah.
            </p>
            <div class="row g-3 pt-2">
                <div class="col-sm-6">
                    <div class="border rounded-3 p-3 bg-light">
                        <h4 class="fw-bold mb-1" style="color: #0085a2;">24/7</h4>
                        <small class="text-muted">Dedicated Butler Support</small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="border rounded-3 p-3 bg-light">
                        <h4 class="fw-bold mb-1" style="color: #0085a2;">98.4%</h4>
                        <small class="text-muted">Guest Satisfaction Rate</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border">
                <img src="{{ asset('images/branding/hero-bg.webp') }}" class="w-100 object-fit-cover" style="min-height: 380px; max-height: 440px;" alt="Ubu Team & Hospitality Culture">
                <div class="position-absolute bottom-0 start-0 end-0 p-4 bg-dark bg-opacity-75 text-white">
                    <h5 class="font-serif fw-bold mb-1">Kehangatan Budaya Yogyakarta</h5>
                    <small class="text-white-50">Menyatukan etika kesopanan tradisional dengan profesionalisme hospitality modern.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Nilai Utama Budaya Ubu -->
    <div class="py-5 border-top">
        <div class="text-center mb-5">
            <h3 class="font-serif fw-bold text-dark">4 Pilar Nilai Kehidupan di Ubu</h3>
            <p class="text-muted">Prinsip kerja yang menginspirasi setiap layanan yang kami persembahkan.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e6f6f9; color: #0085a2;">
                        <i class="bi bi-heart-fill fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark">Sincere Care</h5>
                    <p class="text-secondary small mb-0">Melayani dengan tulus dari hati, peka terhadap kenyamanan dan kebutuhan unik setiap tamu.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #fff9e6; color: #f1c40f;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark">Integrity & Trust</h5>
                    <p class="text-secondary small mb-0">Menjaga kejujuran, transparansi operasional, dan integritas tinggi kepada tamu dan pemilik aset.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e6f6f9; color: #006771;">
                        <i class="bi bi-stars fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark">Excellence</h5>
                    <p class="text-secondary small mb-0">Standar kebersihan kamar tidur, kolam renang, dan fasilitas villa setara resort bintang lima.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e6f6f9; color: #0f6b84;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark">Family Warmth</h5>
                    <p class="text-secondary small mb-0">Membangun lingkungan kerja yang suportif, saling menghargai, dan bertumbuh bersama sebagai keluarga.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Join the Team CTA -->
    <div class="mt-4 p-5 rounded-4 text-white text-center position-relative overflow-hidden" style="background-color: var(--ubu-primary, #0085a2);">
        <h3 class="font-serif fw-bold mb-2 text-white">Ingin Menjadi Bagian Dari Perjalanan Kami?</h3>
        <p class="text-white mb-4 max-w-xl mx-auto" style="max-width: 600px; opacity: 0.95;">
            Kami selalu membuka pintu bagi talenta berdedikasi tinggi di bidang perhotelan dan manajemen properti untuk berkembang bersama Ubu Hospitality.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('career') }}" class="btn btn-ubu-gold btn-lg px-4 py-2 rounded-pill shadow-lg">
                <i class="bi bi-briefcase me-1"></i> Lihat Lowongan Karir
            </a>
            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill">
                <i class="bi bi-info-circle me-1"></i> Pelajari Tentang Kami
            </a>
        </div>
    </div>
</div>
@endsection
