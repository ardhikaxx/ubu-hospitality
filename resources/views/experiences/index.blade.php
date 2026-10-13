@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Experience & Aktivitas</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Pengalaman & Aktivitas Menarik</h1>
        <p class="text-muted small mb-0">Lengkapi waktu santai Anda di Yogyakarta dengan ragam aktivitas khas dan momen berharga bersama orang tercinta.</p>
    </div>
</div>

<div class="container py-5">
    @if($experiences->isEmpty())
        <x-empty-state
            icon="bi-compass"
            title="Belum Ada Aktivitas Terdaftar"
            message="Koleksi aktivitas sedang dalam proses kurasi."
        />
    @else
        <div class="row g-4">
            @foreach($experiences as $exp)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card">
                        <div style="aspect-ratio: 16 / 10; overflow: hidden; position: relative;">
                            <img src="{{ $exp->featured_image }}" alt="{{ $exp->title }}" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">
                                {{ ucfirst($exp->category) }}
                            </span>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h4 class="font-serif fs-5 fw-bold text-dark mb-2">{{ $exp->title }}</h4>
                            <p class="small text-muted mb-3 flex-grow-1">{{ $exp->short_description }}</p>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <span class="fw-bold text-success small">{{ $exp->price_display }}</span>
                                <a href="{{ route('experience.show', $exp->slug) }}" class="btn btn-sm btn-outline-secondary">
                                    Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
