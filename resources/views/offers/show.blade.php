@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offer.index') }}" class="text-decoration-none text-muted">Offers</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $promotion->code }}</li>
            </ol>
        </nav>
        <span class="badge bg-danger fw-bold px-3 py-1 mb-2">{{ $promotion->discount_label }}</span>
        <h1 class="font-serif fw-bold text-dark mb-1">{{ $promotion->title }}</h1>
        <p class="text-muted small mb-0">{{ $promotion->subtitle }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="aspect-ratio: 16 / 9;">
                <x-fallback-image :src="$promotion->banner_image" alt="{{ $promotion->title }}" class="w-100 h-100 object-fit-cover" />
            </div>

            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h4 class="font-serif fw-bold text-dark mb-3">Deskripsi Promo</h4>
                <div class="text-secondary" style="line-height: 1.8;">
                    {!! nl2br(e($promotion->description)) !!}
                </div>
            </div>

            @if($promotion->terms_conditions)
                <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                    <h4 class="font-serif fw-bold text-dark mb-3">Syarat & Ketentuan</h4>
                    <div class="small text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($promotion->terms_conditions)) !!}
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-md bg-white position-sticky" style="top: 90px;">
                <h5 class="fw-bold text-dark mb-3">Kode Kupon Promo</h5>
                <div class="p-3 bg-light rounded-3 text-center border border-dashed mb-3">
                    <span class="fs-4 font-monospace fw-bold text-success">{{ $promotion->code }}</span>
                </div>

                <div class="small text-muted mb-3">
                    <div class="mb-2"><i class="bi bi-calendar-event me-2 text-primary"></i> Periode Booking: <strong>s/d {{ $promotion->booking_period_end->format('d M Y') }}</strong></div>
                    <div><i class="bi bi-clock-history me-2 text-primary"></i> Periode Menginap: <strong>{{ $promotion->stay_period_start->format('d M') }} - {{ $promotion->stay_period_end->format('d M Y') }}</strong></div>
                </div>

                <a href="{{ route('stay.index', ['promo_code' => $promotion->code]) }}" class="btn btn-ubu-primary w-100 py-3 fw-bold mb-2">
                    Gunakan Promo Ini <i class="bi bi-arrow-right ms-1"></i>
                </a>

                <div class="text-center small text-muted" style="font-size: 0.75rem;">
                    Potongan akan otomatis diaplikasikan saat proses checkout.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
