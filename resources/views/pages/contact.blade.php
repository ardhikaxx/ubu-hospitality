@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kontak Kami</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Hubungi Ubu Hospitality</h1>
        <p class="text-muted small mb-0">Tim customer support dan reservasi kami siap membantu pertanyaan dan kebutuhan liburan Anda.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-5">
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h4 class="font-serif fw-bold text-dark mb-4">Kantor Pusat & Operasional</h4>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-light text-danger p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-geo-alt fs-4"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark">Alamat Resmi</strong>
                        <span class="text-muted small">{{ \App\Models\Setting::get('contact_address', 'Jl. Gito Gati No. 88, Sleman, D.I. Yogyakarta') }}</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-light text-success p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-whatsapp fs-4"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark">Layanan WhatsApp CS</strong>
                        <span class="text-muted small">{{ \App\Models\Setting::get('contact_whatsapp', '+62 812-3456-7890') }}</span>
                        <div class="mt-1">
                            <a href="{{ \App\Models\Setting::get('contact_whatsapp_url', 'https://wa.me/6281234567890') }}" target="_blank" class="btn btn-sm btn-outline-success">
                                Chat Sekarang <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="rounded-circle bg-light text-primary p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark">Email Reservasi & Umum</strong>
                        <span class="text-muted small">{{ \App\Models\Setting::get('contact_email', 'reservation@ubuhospitality.com') }}</span>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <div class="rounded-circle bg-light text-warning p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                        <i class="bi bi-clock fs-4"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark">Jam Operasional Layanan Tamu</strong>
                        <span class="text-muted small">Setiap Hari: 07:00 - 23:00 WIB (Layanan Butler Villa 24 Jam)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Direct Message Form -->
        <div class="col-lg-7">
            <div class="card border rounded-4 p-4 p-md-5 shadow-sm bg-white">
                <h4 class="font-serif fw-bold text-dark mb-2">Kirim Pesan atau Pertanyaan</h4>
                <p class="small text-muted mb-4">Isi formulir di bawah ini dan kami akan membalas via email atau WhatsApp.</p>

                <form onsubmit="event.preventDefault(); Swal.fire({icon: 'success', title: 'Pesan Terkirim', text: 'Terima kasih telah menghubungi kami. Tim kami akan segera merespons.', confirmButtonColor: '#1b3b2b'}); this.reset();">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Anda</label>
                            <input type="text" class="form-control" required placeholder="Nama lengkap">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control" required placeholder="0812...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" required placeholder="email@anda.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Topik Pertanyaan</label>
                            <select class="form-select">
                                <option>Bantuan Reservasi Villa</option>
                                <option>Informasi Khusus Buruj Villa Syariah</option>
                                <option>Pemesanan Khusus / Acara Keluarga</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Pesan Anda</label>
                            <textarea rows="4" class="form-control" required placeholder="Tuliskan pertanyaan atau kebutuhan Anda..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-ubu-primary px-4 py-2">
                        <i class="bi bi-send me-1"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
