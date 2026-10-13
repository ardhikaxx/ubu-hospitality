@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tanya Jawab (FAQ)</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Pertanyaan yang Sering Diajukan (FAQ)</h1>
        <p class="text-muted small mb-0">Temukan jawaban seputar pemesanan villa, aturan syariah di Buruj Villa, dan fasilitas yang tersedia.</p>
    </div>
</div>

<div class="container py-5">
    <div class="max-w-3xl mx-auto" style="max-width: 860px;">
        <div class="accordion accordion-flush bg-white rounded-4 border p-3 shadow-sm" id="faqAccordion">
            <div class="accordion-item border-bottom py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        1. Bagaimana cara memesan villa di Ubu Hospitality?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        Anda dapat memilih villa yang diinginkan melalui menu <strong>STAY</strong> atau form pencarian di beranda, memeriksa ketersediaan tanggal, dan menekan tombol <strong>Pesan Sekarang</strong>. Sistem kami terintegrasi langsung dengan booking engine resmi SENTEC yang memastikan ketersediaan dan tarif real-time.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-bottom py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        2. Apa perbedaan antara Ubu Villa dan Buruj Villa?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        <strong>Ubu Villa</strong> mengusung konsep luxury tropical private sanctuary untuk liburan umum dan keluarga dengan kolam renang privat. Sedangkan <strong>Buruj Villa</strong> mengusung konsep syariah murni dengan jaminan privasi kolam renang tanpa celah pandang dari luar, lingkungan 100% bebas alkohol dan rokok, serta fasilitas ibadah lengkap (sajadah, mukena, arah kiblat terverifikasi) khusus untuk keluarga muslim atau pasangan sah.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-bottom py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        3. Apakah seluruh villa memiliki kolam renang pribadi?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        Hampir seluruh properti Ubu Villa dan Buruj Villa memiliki <em>private pool</em> eksklusif di dalam area villa yang hanya digunakan oleh Anda dan rombongan Anda tanpa berbagi dengan tamu lain. Anda dapat melihat badge "Private Pool" pada kartu properti.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-bottom py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        4. Pukul berapa waktu check-in dan check-out?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        Waktu standar check-in dimulai pukul <strong>14:00 WIB</strong>, dan waktu check-out maksimal pukul <strong>12:00 WIB</strong>. Permintaan <em>early check-in</em> atau <em>late check-out</em> bergantung pada ketersediaan kamar dan dapat dikoordinasikan dengan tim butler kami.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-bottom py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        5. Apakah sarapan terapung (floating breakfast) sudah termasuk?
                    </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        Paket floating breakfast dapat dipilih saat reservasi atau ditambahkan saat Anda tiba di villa. Butler kami akan mengatur nampan terapung dan hidangan hangat sesuai waktu yang Anda inginkan.
                    </div>
                </div>
            </div>

            <div class="accordion-item py-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold text-dark font-serif" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                        6. Bagaimana metode pembayaran yang tersedia?
                    </button>
                </h2>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary small" style="line-height: 1.8;">
                        Pembayaran didukung oleh gateway resmi DOKU dan transfer bank terverifikasi, mencakup Virtual Account (BCA, Mandiri, BNI, BRI, Permata), QRIS, kartu kredit Visa/Mastercard, dan metode resmi lainnya.
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h5 class="fw-bold text-dark mb-2">Masih Memiliki Pertanyaan Lain?</h5>
            <p class="small text-muted mb-3">Tim reservasi kami siap menjawab dan membantu rencana liburan Anda.</p>
            <a href="{{ \App\Models\Setting::get('contact_whatsapp_url', 'https://wa.me/6281234567890') }}" target="_blank" class="btn btn-ubu-primary px-4">
                <i class="bi bi-whatsapp me-1"></i> Tanya Tim Customer Service
            </a>
        </div>
    </div>
</div>
@endsection
