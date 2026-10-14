@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penawaran & Promo</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Penawaran Eksklusif & Promo Menginap</h1>
        <p class="text-muted small mb-0">Manfaatkan potongan harga langsung untuk reservasi villa privat dan liburan syariah di Yogyakarta.</p>
    </div>
</div>

<div class="container py-5">
    @if($promotions->isEmpty())
        <x-empty-state
            icon="bi-tag"
            title="Belum Ada Promo Aktif"
            message="Saat ini belum ada penawaran aktif. Pantau terus halaman ini atau follow media sosial kami untuk update promo terbaru."
            actionText="Jelajahi Villa"
            :actionUrl="route('stay.index')"
        />
    @else
        <div class="row g-4">
            @foreach($promotions as $promo)
                <div class="col-md-6 col-lg-4">
                    <x-promo-card :promotion="$promo" />
                </div>
            @endforeach
        </div>
    @endif

    <!-- New User Coupons Section -->
    <div id="coupons" class="mt-5 pt-4 border-top">
        <div class="text-center mb-4">
            <span class="section-pill">Kupon Diskon Langsung</span>
            <h2 class="font-serif fw-bold text-dark">Promo Pengguna Baru (Welcome Offer)</h2>
            <p class="text-muted small max-w-xl mx-auto" style="max-width: 650px;">
                Baru pertama kali memesan di Ubu Hospitality? Manfaatkan kupon selamat datang berikut untuk mendapatkan potongan harga spesial pada masa inap pertama Anda.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border rounded-4 p-4 shadow-sm bg-white position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 small fw-bold rounded-bottom-start">
                        <i class="bi bi-star-fill text-warning me-1"></i> Promo Terverifikasi
                    </div>
                    <div class="row align-items-center g-4">
                        <div class="col-md-5 text-center text-md-start">
                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1 mb-2">PENGGUNA BARU</span>
                            <h3 class="font-serif fw-bold text-dark mb-1">Diskon 15%</h3>
                            <p class="text-muted small mb-0">Untuk reservasi pertama Anda di seluruh jaringan Ubu Villa & Buruj Villa.</p>
                        </div>
                        <div class="col-md-7">
                            <div class="p-3 rounded-3 bg-light border border-dashed d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.75rem;">Kode Kupon:</small>
                                    <span class="fs-4 font-monospace fw-bold text-dark" id="welcomeCouponCode">UBUWELCOME</span>
                                </div>
                                <button type="button" class="btn btn-ubu-primary px-3 py-2 text-nowrap rounded-pill btn-sm" onclick="copyCoupon('UBUWELCOME')">
                                    <i class="bi bi-clipboard me-1"></i> Salin Kode
                                </button>
                            </div>
                            <div class="mt-2 text-muted small" style="font-size: 0.8rem;">
                                <i class="bi bi-info-circle text-info me-1"></i> Masukkan kode saat reservasi atau informasikan ke tim Butler via WhatsApp.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyCoupon(code) {
        navigator.clipboard.writeText(code).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Kode Kupon Disalin!',
                text: 'Kode ' + code + ' telah disalin ke clipboard Anda.',
                confirmButtonColor: '#0085a2',
                timer: 2500
            });
        }).catch(function() {
            Swal.fire({
                icon: 'info',
                title: 'Kode Kupon',
                text: 'Kode kupon Anda adalah: ' + code,
                confirmButtonColor: '#0085a2'
            });
        });
    }
</script>
@endpush
@endsection
