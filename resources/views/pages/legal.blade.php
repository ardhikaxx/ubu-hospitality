@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">{{ $page->title }}</h1>
        <p class="text-muted small mb-0">{{ $page->subtitle }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="max-w-3xl mx-auto bg-white rounded-4 border p-4 p-md-5 shadow-sm" style="max-width: 860px; line-height: 1.85;">
        <div class="text-secondary">
            @php
                $mainSection = $page->sections->first();
            @endphp

            @if($mainSection && $mainSection->content)
                {!! nl2br(e($mainSection->content)) !!}
            @else
                <h4 class="font-serif fw-bold text-dark mb-3">1. Ketentuan Umum</h4>
                <p>
                    Dokumen ini mengatur penggunaan layanan dan situs resmi <strong>{{ \App\Models\Setting::get('company_name', 'PT Ubu Hospitality Indonesia') }}</strong> ("Ubu Hospitality"). Dengan mengakses dan menggunakan situs ini, Anda menyetujui seluruh ketentuan yang tercantum.
                </p>

                <h4 class="font-serif fw-bold text-dark mb-3 mt-4">2. Pemesanan dan Reservasi</h4>
                <p>
                    Seluruh tarif kamar, ketersediaan unit, dan status pemesanan terintegrasi langsung dengan sistem manajemen reservasi resmi SENTEC. Konfirmasi reservasi yang sah diberikan setelah proses verifikasi atau pembayaran berhasil diselesaikan melalui penyedia pembayaran berlisensi (DOKU).
                </p>

                <h4 class="font-serif fw-bold text-dark mb-3 mt-4">3. Kebijakan Khusus Buruj Villa (Syariah)</h4>
                <p>
                    Tamu yang melakukan pemesanan di properti di bawah naungan brand Buruj Villa wajib mematuhi ketentuan syariah yang berlaku, termasuk larangan membawa minuman beralkohol, larangan zat terlarang, serta kewajiban menunjukkan identitas sah pasangan suami istri untuk pasangan non-keluarga besar.
                </p>

                <h4 class="font-serif fw-bold text-dark mb-3 mt-4">4. Privasi & Keamanan Data</h4>
                <p>
                    Kami berkomitmen menjaga kerahasiaan data pribadi Anda, termasuk nama, email, nomor WhatsApp, dan data pemesanan. Data tersebut hanya digunakan untuk keperluan layanan hospitality, operasional reservasi, dan komunikasi terkait status pemesanan Anda. Kami tidak menjual data Anda kepada pihak ketiga.
                </p>

                <h4 class="font-serif fw-bold text-dark mb-3 mt-4">5. Kontak Pertanyaan Hukum</h4>
                <p>
                    Apabila Anda memiliki pertanyaan terkait dokumen legal ini, silakan menghubungi tim legal kami melalui email resmi di <strong>{{ \App\Models\Setting::get('contact_email', 'reservation@ubuhospitality.com') }}</strong>.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
