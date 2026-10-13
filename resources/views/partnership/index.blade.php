@extends('layouts.public')

@section('content')
<!-- Partnership Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #16201b 0%, #1b3b2b 100%); color: #ffffff;">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-1 mb-3">Hospitality Asset Management</span>
                <h1 class="font-serif display-4 fw-bold text-white mb-3">
                    Maksimalkan Potensi Properti Anda Bersama Ubu Hospitality
                </h1>
                <p class="fs-5 text-white-50 mb-4" style="line-height: 1.7;">
                    Kami adalah mitra terpercaya pemilik aset dalam mengelola villa privat, akomodasi syariah, dan glamping di Yogyakarta. Solusi menyeluruh dari operasional harian, pemasaran digital, hingga pemeliharaan aset berstandar tinggi.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#submitSection" class="btn btn-ubu-accent btn-lg px-4 py-3 fw-bold shadow">
                        <i class="bi bi-pencil-square me-2"></i> Ajukan Properti Anda
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20Tim%20Kemitraan%20Ubu%20Hospitality%2C%20saya%20tertarik%20berdiskusi%20mengenai%20kerja%20sama%20properti" target="_blank" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="bi bi-whatsapp me-2"></i> Konsultasi Tim Partnership
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 rounded-4 p-4 shadow-lg text-dark bg-white">
                    <h5 class="fw-bold text-dark mb-3">Mengapa Bermitra Dengan Kami?</h5>
                    <div class="d-flex gap-3 mb-3">
                        <div class="rounded-circle bg-success-subtle text-success p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                            <i class="bi bi-graph-up-arrow fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Okupansi & Pendapatan Optimal</strong>
                            <small class="text-muted">Kombinasi booking langsung di website resmi dan distribusi multi-channel meningkatkan hasil sewa.</small>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div class="rounded-circle bg-success-subtle text-success p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                            <i class="bi bi-shield-check fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Pemeliharaan Aset Terstandar</strong>
                            <small class="text-muted">Inspeksi rutin dan tim maintenance internal menjaga nilai aset properti Anda tetap prima.</small>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="rounded-circle bg-success-subtle text-success p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                            <i class="bi bi-file-earmark-spreadsheet fs-5"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Laporan Keuangan Transparan</strong>
                            <small class="text-muted">Pemilik properti menerima rincian pendapatan dan okupansi bulanan secara detail tanpa biaya tersembunyi.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cooperation Models Section -->
<section class="section-padding bg-white" id="models">
    <div class="container">
        <x-section-header
            pill="Model Kerja Sama"
            title="Skema Fleksibel Sesuai Kebutuhan Anda"
            desc="Kami menawarkan pilihan kemitraan yang transparan dan dapat disesuaikan dengan kesiapan aset Anda."
            center="true"
        />

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border rounded-4 p-4 h-100 shadow-sm property-card">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-success mb-3" style="width: 56px; height: 56px;">
                        <i class="bi bi-gem fs-3"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Full Management (Turnkey)</h4>
                    <p class="small text-muted mb-4 flex-grow-1">
                        Solusi bebas repot bagi pemilik aset. Tim Ubu mengelola operasional harian, pemasaran, resepsionis, housekeeping, perlengkapan, hingga penanganan komplain tamu.
                    </p>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Standarisasi operasional lengkap</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Termasuk tim butler & kebersihan</li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Pembagian hasil bulanan transparan</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-4 p-4 h-100 shadow-sm property-card">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-primary mb-3" style="width: 56px; height: 56px;">
                        <i class="bi bi-pie-chart fs-3"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Revenue Sharing</h4>
                    <p class="small text-muted mb-4 flex-grow-1">
                        Skema bagi hasil pendapatan kotor atau bersih yang adil, memungkinkan pemilik menikmati pasif income optimal seiring bertumbuhnya performa reservasi properti.
                    </p>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Keselarasan target antara mitra dan Ubu</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Laporan performa real-time</li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Distribusi channel penjualan terintegrasi</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border rounded-4 p-4 h-100 shadow-sm property-card">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-warning mb-3" style="width: 56px; height: 56px;">
                        <i class="bi bi-building-gear fs-3"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Branding & Konsultasi</h4>
                    <p class="small text-muted mb-4 flex-grow-1">
                        Bagi pemilik lahan atau bangunan dalam tahap perencanaan yang membutuhkan bimbingan konsep arsitektur, perhitungan ROI, hingga penetapan brand (Ubu Villa atau Buruj Villa).
                    </p>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Analisis potensi pasar & kelayakan bisnis</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-1"></i> Rekomendasi layout privat & syariah</li>
                        <li><i class="bi bi-check2 text-success me-1"></i> Integrasi sistem reservasi SENTEC</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Proposal Submission Form Section (RedDoorz-inspired lead capture) -->
<section class="section-padding" style="background-color: var(--ubu-bg-alt);" id="submitSection">
    <div class="container">
        <div class="max-w-3xl mx-auto" style="max-width: 860px;">
            <div class="text-center mb-4">
                <span class="section-pill">Formulir Kemitraan</span>
                <h2 class="font-serif fw-bold text-dark">Ajukan Properti Anda</h2>
                <p class="text-muted small">
                    Isi data properti di bawah ini. Tim Business Development Ubu Hospitality akan meninjau kelayakan dan menghubungi Anda dalam 1x24 jam kerja.
                </p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 rounded-4 p-4 p-md-5 shadow-md bg-white">
                @if(session('reference_no'))
                    <div class="alert alert-success border-0 rounded-3 p-3 mb-4 d-flex align-items-center gap-3">
                        <i class="bi bi-check-circle-fill fs-2 text-success"></i>
                        <div>
                            <strong class="d-block">Pengajuan Berhasil Tercatat!</strong>
                            <small>Nomor Referensi Anda: <strong>{{ session('reference_no') }}</strong>. Mohon simpan kode ini untuk keperluan tindak lanjut.</small>
                        </div>
                    </div>
                @endif

                <form action="{{ route('partnership.store') }}" method="POST">
                    @csrf

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">1. Data Pemilik / Perwakilan</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap Pemilik <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror" value="{{ old('owner_name') }}" required placeholder="Contoh: Bpk. Bambang Wijaya">
                            @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Perusahaan / PT / CV (Jika Ada)</label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" placeholder="Opsional">
                            @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Contoh: email@domain.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">2. Data Properti & Lokasi</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Properti <span class="text-danger">*</span></label>
                            <input type="text" name="property_name" class="form-control @error('property_name') is-invalid @enderror" value="{{ old('property_name') }}" required placeholder="Contoh: Villa Asri Palagan">
                            @error('property_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Properti <span class="text-danger">*</span></label>
                            <select name="property_type" class="form-select @error('property_type') is-invalid @enderror" required>
                                <option value="villa" {{ old('property_type') == 'villa' ? 'selected' : '' }}>Private Pool Villa</option>
                                <option value="glamping" {{ old('property_type') == 'glamping' ? 'selected' : '' }}>Glamping</option>
                                <option value="resort" {{ old('property_type') == 'resort' ? 'selected' : '' }}>Boutique Resort</option>
                                <option value="hotel" {{ old('property_type') == 'hotel' ? 'selected' : '' }}>Hotel / Guest House</option>
                                <option value="land" {{ old('property_type') == 'land' ? 'selected' : '' }}>Lahan Kosong Siap Bangun</option>
                                <option value="other" {{ old('property_type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('property_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kota / Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', 'Sleman, D.I. Yogyakarta') }}" required>
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Kamar Tidur</label>
                            <input type="number" name="number_of_rooms" class="form-control @error('number_of_rooms') is-invalid @enderror" value="{{ old('number_of_rooms', 3) }}" min="1" max="200">
                            @error('number_of_rooms') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap Properti <span class="text-danger">*</span></label>
                            <textarea name="property_address" rows="2" class="form-control @error('property_address') is-invalid @enderror" required placeholder="Jl. Raya / Desa, Kecamatan, Kelurahan...">{{ old('property_address') }}</textarea>
                            @error('property_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Luas Tanah (m²)</label>
                            <input type="number" name="land_size_sqm" class="form-control @error('land_size_sqm') is-invalid @enderror" value="{{ old('land_size_sqm') }}" placeholder="Contoh: 500">
                            @error('land_size_sqm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Luas Bangunan (m²)</label>
                            <input type="number" name="building_size_sqm" class="form-control @error('building_size_sqm') is-invalid @enderror" value="{{ old('building_size_sqm') }}" placeholder="Contoh: 300">
                            @error('building_size_sqm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">3. Preferensi Kerja Sama</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Model Kerja Sama Diminati <span class="text-danger">*</span></label>
                            <select name="partnership_model" class="form-select @error('partnership_model') is-invalid @enderror" required>
                                <option value="full_management" {{ old('partnership_model') == 'full_management' ? 'selected' : '' }}>Full Asset & Operations Management</option>
                                <option value="revenue_sharing" {{ old('partnership_model') == 'revenue_sharing' ? 'selected' : '' }}>Revenue Sharing (Bagi Hasil)</option>
                                <option value="branding_only" {{ old('partnership_model') == 'branding_only' ? 'selected' : '' }}>Branding & Digital Sales Distribution</option>
                                <option value="consultation" {{ old('partnership_model') == 'consultation' ? 'selected' : '' }}>Konsultasi Pengembangan Baru</option>
                            </select>
                            @error('partnership_model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Properti Saat Ini <span class="text-danger">*</span></label>
                            <select name="current_status" class="form-select @error('current_status') is-invalid @enderror" required>
                                <option value="ready_to_operate" {{ old('current_status') == 'ready_to_operate' ? 'selected' : '' }}>Siap Beroperasi (Furnished)</option>
                                <option value="under_construction" {{ old('current_status') == 'under_construction' ? 'selected' : '' }}>Sedang Tahap Pembangunan</option>
                                <option value="design_planning" {{ old('current_status') == 'design_planning' ? 'selected' : '' }}>Tahap Perencanaan / Arsitektur</option>
                                <option value="land_only" {{ old('current_status') == 'land_only' ? 'selected' : '' }}>Masih Lahan Kosong</option>
                            </select>
                            @error('current_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan Tambahan / Ekspektasi Pemilik</label>
                            <textarea name="proposal_notes" rows="3" class="form-control @error('proposal_notes') is-invalid @enderror" placeholder="Ceritakan fitur unik properti Anda, kolam renang, akses jalan, atau pertanyaan khusus...">{{ old('proposal_notes') }}</textarea>
                            @error('proposal_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ubu-primary btn-lg w-100 py-3 shadow">
                        <i class="bi bi-send-fill me-2"></i> Kirim Formulir Pengajuan
                    </button>
                    <div class="text-center small text-muted mt-2">
                        Data Anda dijaga kerahasiaannya dan hanya digunakan untuk keperluan evaluasi tim kemitraan Ubu Hospitality.
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
