@extends('layouts.public')

@section('content')
<!-- Hero Header -->
<div class="py-5 text-white" style="background-color: var(--ubu-primary, #0085a2);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('about') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Tentang Kami</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">CSR & Keberlanjutan</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">Corporate Social Responsibility</span>
        <h1 class="font-serif display-5 fw-bold mb-3 text-white">Tumbuh Bersama Komunitas & Alam</h1>
        <p class="lead text-white max-w-2xl mb-0" style="max-width: 720px; opacity: 0.95;">
            Komitmen nyata Ubu Hospitality dalam memberdayakan masyarakat sekitar, mendukung pelaku UMKM lokal, dan menjaga kelestarian lingkungan hidup di setiap destinasi properti kami.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Intro & Impact Numbers -->
    <div class="row g-4 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="text-uppercase fw-bold small" style="letter-spacing: 1.5px; color: #0085a2;">Dampak Nyata</span>
            <h2 class="font-serif fw-bold text-dark mt-2 mb-3">Pariwisata Berkelanjutan yang Memberi Manfaat Luas</h2>
            <p class="text-secondary" style="line-height: 1.8;">
                Kami percaya bahwa kehadiran setiap unit Ubu Villa dan Buruj Villa harus memberikan dampak positif yang berkelanjutan bagi warga sekitar. Keberhasilan kami diukur dari seberapa besar kami mampu membuka lapangan kerja baru, mensejahterakan keluarga lokal, serta menjaga keharmonisan alam Yogyakarta.
            </p>
            <div class="row g-3 pt-3">
                <div class="col-6">
                    <div class="border rounded-4 p-3 bg-light text-center">
                        <h3 class="fw-bold mb-1" style="color: #0085a2;">85%+</h3>
                        <small class="text-muted">Tenaga Kerja Lokal Yogyakarta</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded-4 p-3 bg-light text-center">
                        <h3 class="fw-bold mb-1" style="color: #0085a2;">50+</h3>
                        <small class="text-muted">Mitra UMKM & Supplier Desa</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="rounded-4 overflow-hidden shadow-lg border">
                <img src="{{ asset('images/celebrity/katalog-6.jpg') }}" class="w-100 object-fit-cover" style="min-height: 380px; max-height: 420px;" alt="Ubu Hospitality Community Initiative">
            </div>
        </div>
    </div>

    <!-- 3 Pilar Program CSR -->
    <div class="py-5 border-top">
        <div class="text-center mb-5">
            <h3 class="font-serif fw-bold text-dark">3 Fokus Utama Inisiatif Keberlanjutan</h3>
            <p class="text-muted">Langkah terarah untuk kesejahteraan sosial, ekonomi, dan lingkungan.</p>
        </div>

        <div class="row g-4">
            <!-- Pilar 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e6f6f9; color: #0085a2;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Pemberdayaan Warga Lokal</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.7;">
                        Memberikan pelatihan vokasi hospitality dan merekrut talenta muda dari desa-desa sekitar properti di Sleman dan Bantul menjadi butler profesional dan staf operasional dengan standar hospitality terakreditasi.
                    </p>
                </div>
            </div>

            <!-- Pilar 2 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #fff9e6; color: #f1c40f;">
                        <i class="bi bi-shop fs-3"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Kemitraan UMKM & Petani</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.7;">
                        Seluruh kebutuhan sarapan pagi, bahan barbeque segar, laundry ramah lingkungan, hingga sewa kendaraan jeep tour Merapi dipasok langsung dari UMKM warga lokal di sekitar villa.
                    </p>
                </div>
            </div>

            <!-- Pilar 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background-color: #e6f6f9; color: #006771;">
                        <i class="bi bi-tree-fill fs-3"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Kelestarian Lingkungan Hijau</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.7;">
                        Menerapkan pengelolaan filtrasi air kolam renang yang hemat energi, pembatasan plastik sekali pakai di seluruh villa, dan program penghijauan rutin bersama warga bantaran sungai dan lereng Merapi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Partnership Callout -->
    <div class="mt-4 p-5 rounded-4 text-white text-center position-relative overflow-hidden" style="background-color: var(--ubu-primary, #0085a2);">
        <h3 class="font-serif fw-bold mb-2 text-white">Ingin Berkolaborasi Dalam Gerakan Sosial?</h3>
        <p class="text-white mb-4 max-w-xl mx-auto" style="max-width: 600px; opacity: 0.95;">
            Kami menyambut terbuka inisiatif kolaborasi komunitas, institusi pendidikan, dan organisasi lingkungan untuk menciptakan dampak kebaikan yang lebih luas.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('contact') }}" class="btn btn-ubu-gold btn-lg px-4 py-2 rounded-pill shadow-lg">
                <i class="bi bi-envelope me-1"></i> Hubungi Tim Kemitraan CSR
            </a>
            <a href="https://api.whatsapp.com/send?phone=6282320003297" target="_blank" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp Sekretariat
            </a>
        </div>
    </div>
</div>
@endsection
