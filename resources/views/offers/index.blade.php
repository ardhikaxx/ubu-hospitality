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
</div>
@endsection
