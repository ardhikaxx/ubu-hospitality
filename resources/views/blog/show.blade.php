@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Blog</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>
        <span class="badge bg-light text-dark border px-3 py-1 mb-2">{{ $post->category?->name }}</span>
        <h1 class="font-serif fw-bold text-dark display-6 mb-2">{{ $post->title }}</h1>
        <div class="small text-muted d-flex align-items-center gap-3">
            <span><i class="bi bi-person me-1"></i> {{ $post->author?->name ?? 'Redaksi Ubu' }}</span>
            <span><i class="bi bi-calendar3 me-1"></i> {{ $post->published_at?->format('d M Y') }}</span>
            <span><i class="bi bi-clock me-1"></i> {{ $post->reading_time_minutes }} menit baca</span>
            <span><i class="bi bi-eye me-1"></i> {{ $post->views_count }} pembaca</span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="aspect-ratio: 16 / 9;">
                <x-fallback-image :src="$post->featured_image" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover" />
            </div>

            <article class="bg-white p-4 p-md-5 rounded-4 border shadow-sm article-content" style="font-size: 1.05rem; line-height: 1.85;">
                {!! $post->content !!}
            </article>

            <!-- Linked Properties -->
            @if($relatedProperties->isNotEmpty())
                <div class="mt-5 pt-4 border-top">
                    <h4 class="font-serif fw-bold text-dark mb-3">Rekomendasi Properti Terkait</h4>
                    <div class="row g-4">
                        @foreach($relatedProperties as $prop)
                            <div class="col-md-6">
                                <x-property-card :property="$prop" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4 position-sticky" style="top: 90px;">
                <h5 class="fw-bold text-dark mb-3">Artikel Terkait</h5>
                <div class="list-group list-group-flush">
                    @foreach($relatedPosts as $rel)
                        <a href="{{ route('blog.show', $rel->slug) }}" class="list-group-item list-group-item-action px-0 py-3 border-bottom">
                            <h6 class="font-serif fw-bold text-dark mb-1">{{ $rel->title }}</h6>
                            <small class="text-muted d-block">{{ $rel->published_at?->format('d M Y') }}</small>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-top text-center">
                    <h6 class="fw-bold text-dark mb-2">Ingin Menginap di Ubu?</h6>
                    <p class="small text-muted mb-3">Temukan private pool villa impian Anda dengan harga terbaik.</p>
                    <a href="{{ route('stay.index') }}" class="btn btn-ubu-primary btn-sm w-100 py-2">
                        Cek Ketersediaan Villa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
