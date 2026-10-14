@extends('layouts.public')

@section('content')
<!-- Hero Header -->
<div class="py-5 text-white" style="background-color: var(--ubu-primary, #0085a2);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('about') }}" class="text-white text-decoration-none" style="opacity: 0.85;">Tentang Kami</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Karir</li>
            </ol>
        </nav>
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold text-uppercase mb-2" style="letter-spacing: 1px;">We Are Hiring</span>
        <h1 class="font-serif display-5 fw-bold mb-3 text-white">Bergabung Bersama Ubu Hospitality</h1>
        <p class="lead text-white max-w-2xl mb-0" style="max-width: 720px; opacity: 0.95;">
            Kembangkan potensi terbaik Anda di industri manajemen properti dan pariwisata luxury villa terdepan di Indonesia dengan budaya kerja kekeluargaan dan jenjang karir nyata.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <!-- Why Work with Us -->
    <div class="row g-4 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="text-uppercase fw-bold small" style="letter-spacing: 1.5px; color: #0085a2;">Kenapa Ubu Hospitality</span>
            <h2 class="font-serif fw-bold text-dark mt-2 mb-3">Tempat Terbaik untuk Berkarya dan Bertumbuh</h2>
            <p class="text-secondary" style="line-height: 1.8;">
                Sebagai salah satu manajemen villa dengan pertumbuhan tercepat di Yogyakarta, kami senantiasa menghargai inisiatif, dedikasi, dan keramahan setiap anggota tim kami. Kami menyediakan lingkungan kerja yang dinamis, inklusif, dan mendukung keseimbangan hidup.
            </p>
            <div class="row g-3 pt-2">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-3 p-3 border rounded-3 bg-light">
                        <i class="bi bi-award fs-3" style="color: #0085a2;"></i>
                        <div>
                            <div class="fw-bold text-dark small">Paket Remunerasi Kompetitif</div>
                            <small class="text-muted">Gaji pokok, insentif & BPJS</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex align-items-center gap-3 p-3 border rounded-3 bg-light">
                        <i class="bi bi-graph-up-arrow fs-3" style="color: #0085a2;"></i>
                        <div>
                            <div class="fw-bold text-dark small">Jenjang Karir Jelas</div>
                            <small class="text-muted">Promosi berbasis performa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border">
                <img src="{{ asset('images/branding/hero-bg.webp') }}" class="w-100 object-fit-cover" style="min-height: 360px; max-height: 420px;" alt="Work Culture at Ubu Villa">
                <div class="position-absolute bottom-0 start-0 end-0 p-4 bg-dark bg-opacity-75 text-white">
                    <h5 class="font-serif fw-bold mb-1">Budaya Kerja Hangat & Kolaboratif</h5>
                    <small class="text-white-50">Menjunjung tinggi profesionalisme dengan suasana kekeluargaan yang erat.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Vacancies List -->
    <div class="pt-4 border-top">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div>
                <h3 class="font-serif fw-bold text-dark mb-1">Lowongan Terbuka Saat Ini</h3>
                <p class="text-muted small mb-0">Temukan posisi yang sesuai dengan keahlian dan passion Anda.</p>
            </div>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill mt-2 mt-md-0">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i> Penempatan: Sleman & Yogyakarta
            </span>
        </div>

        <div class="row g-4">
            <!-- Job 1 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-3 py-1 rounded-pill mb-2">Hospitality Operations</span>
                            <h5 class="font-serif fw-bold text-dark mb-1">Private Villa Butler Specialist</h5>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Yogyakarta • Full Time</small>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Aktif</span>
                    </div>
                    <p class="text-secondary small mb-3" style="line-height: 1.7;">
                        Bertanggung jawab memberikan layanan personal check-in/out, penyajian floating breakfast, asistensi tamu 24 jam, dan memastikan kepuasan tamu selama menginap di villa privat.
                    </p>
                    <ul class="text-secondary small ps-3 mb-4">
                        <li>Pengalaman minimal 1 tahun di industri hospitality / hotel</li>
                        <li>Memiliki kemampuan komunikasi ramah dan etika pelayanan prima</li>
                        <li>Mampu mengendarai motor/mobil dan berdomisili di Yogyakarta</li>
                    </ul>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">Lamar sebelum kuota terpenuhi</small>
                        <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo HRD Ubu Hospitality, saya ingin melamar posisi: Private Villa Butler Specialist.') }}" target="_blank" class="btn btn-sm btn-ubu-primary rounded-pill px-4">
                            Lamar Posisi <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job 2 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-3 py-1 rounded-pill mb-2">Housekeeping</span>
                            <h5 class="font-serif fw-bold text-dark mb-1">Housekeeping Supervisor</h5>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Ngaglik, Sleman • Full Time</small>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Aktif</span>
                    </div>
                    <p class="text-secondary small mb-3" style="line-height: 1.7;">
                        Mengawasi operasional kebersihan villa, kontrol inventaris linen dan amenities, serta memastikan standar sanitasi hotel bintang lima di seluruh unit villa.
                    </p>
                    <ul class="text-secondary small ps-3 mb-4">
                        <li>Pengalaman minimal 2 tahun sebagai Housekeeping Leader/Supervisor</li>
                        <li>Teliti, memiliki standar kebersihan tinggi dan detail-oriented</li>
                        <li>Mampu memimpin tim dan bekerja fleksibel</li>
                    </ul>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">Lamar sebelum kuota terpenuhi</small>
                        <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo HRD Ubu Hospitality, saya ingin melamar posisi: Housekeeping Supervisor.') }}" target="_blank" class="btn btn-sm btn-ubu-primary rounded-pill px-4">
                            Lamar Posisi <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job 3 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-3 py-1 rounded-pill mb-2">Guest Relations</span>
                            <h5 class="font-serif fw-bold text-dark mb-1">Guest Relation & Reservation Officer</h5>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Headquarter Sleman • Full Time</small>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Aktif</span>
                    </div>
                    <p class="text-secondary small mb-3" style="line-height: 1.7;">
                        Melayani inquiries tamu melalui WhatsApp, OTA, dan website, memberikan rekomendasi villa terbaik, serta mengkoordinasikan reservasi dengan tim operasional villa.
                    </p>
                    <ul class="text-secondary small ps-3 mb-4">
                        <li>Pendidikan min. D3/S1 Pariwisata, Komunikasi, atau setara</li>
                        <li>Komunikasi persuasif, cepat tanggap, dan fasih berbahasa Inggris</li>
                        <li>Pengalaman di bidang reservasi hospitality menjadi nilai tambah</li>
                    </ul>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">Lamar sebelum kuota terpenuhi</small>
                        <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo HRD Ubu Hospitality, saya ingin melamar posisi: Guest Relation & Reservation Officer.') }}" target="_blank" class="btn btn-sm btn-ubu-primary rounded-pill px-4">
                            Lamar Posisi <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Job 4 -->
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-3 py-1 rounded-pill mb-2">Maintenance</span>
                            <h5 class="font-serif fw-bold text-dark mb-1">Pool & Villa Maintenance Technician</h5>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Sleman & Yogyakarta • Full Time</small>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Aktif</span>
                    </div>
                    <p class="text-secondary small mb-3" style="line-height: 1.7;">
                        Melakukan perawatan rutin sirkulasi pompa kolam renang, kejernihan air, kelistrikan AC, sanitasi air bersih, serta perbaikan sarana fisik di unit properti villa.
                    </p>
                    <ul class="text-secondary small ps-3 mb-4">
                        <li>Menguasai teknik kelistrikan, pompa air, AC, dan water filtration</li>
                        <li>Memiliki inisiatif tinggi, cekatan, dan mampu troubleshooting cepat</li>
                        <li>Memiliki kendaraan operasional pribadi (motor)</li>
                    </ul>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">Lamar sebelum kuota terpenuhi</small>
                        <a href="https://api.whatsapp.com/send?phone=6282320003297&text={{ urlencode('Halo HRD Ubu Hospitality, saya ingin melamar posisi: Pool & Villa Maintenance Technician.') }}" target="_blank" class="btn btn-sm btn-ubu-primary rounded-pill px-4">
                            Lamar Posisi <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Guide / Direct Contact -->
    <div class="mt-5 p-4 rounded-4 border bg-white shadow-sm">
        <div class="row align-items-center g-3">
            <div class="col-md-8">
                <h5 class="font-serif fw-bold text-dark mb-1">Tidak Menemukan Posisi yang Cocok? Kirimkan CV Terbuka Anda</h5>
                <p class="text-muted small mb-0">
                    Kirimkan berkas Curriculum Vitae (CV) dan portofolio Anda ke email <strong>hr@ubuvilla.com</strong> dengan subjek format <code>[Open Application] Nama - Keahlian</code>.
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="mailto:hr@ubuvilla.com" class="btn btn-outline-dark rounded-pill px-4">
                    <i class="bi bi-envelope me-1"></i> Kirim Email CV
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
