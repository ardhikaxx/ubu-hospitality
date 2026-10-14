@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog & Inspirasi</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Inspirasi Perjalanan & Cerita Menginap</h1>
        <p class="text-muted small mb-0">Rekomendasi wisata tersembunyi di Jogja, tips liburan keluarga, dan inspirasi staycation syariah.</p>
    </div>
</div>

<div class="container py-5">
    <!-- Category pills & Search -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('blog.index') }}" class="filter-pill {{ empty($categorySlug) ? 'active' : '' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="filter-pill {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }} ({{ $cat->posts_count }})
                </a>
            @endforeach
        </div>

        <form action="{{ route('blog.index') }}" method="GET" style="max-width: 280px;" class="w-100">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control rounded-start-pill ps-3" placeholder="Cari artikel..." value="{{ $search }}">
                <button class="btn btn-dark rounded-end-pill px-3" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>

    @if($posts->isEmpty())
        <x-empty-state
            icon="bi-journal-x"
            title="Tidak Ada Artikel Ditemukan"
            message="Belum ada artikel yang sesuai dengan filter atau kata kunci Anda."
            actionText="Tampilkan Semua Artikel"
            :actionUrl="route('blog.index')"
        />
    @else
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 property-card bg-white">
                        <div style="aspect-ratio: 16 / 10; overflow: hidden;">
                            <x-fallback-image :src="$post->featured_image" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover" loading="lazy" />
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                <span class="badge bg-light text-dark border">{{ $post->category?->name }}</span>
                                <span>&bull; {{ $post->reading_time_minutes }} menit baca</span>
                            </div>
                            <h4 class="font-serif fs-5 fw-bold text-dark mb-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <p class="small text-muted mb-3 flex-grow-1">{{ $post->excerpt }}</p>
                            <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">{{ $post->published_at ? $post->published_at->format('d M Y') : '' }}</small>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-success small fw-bold text-decoration-none">
                                    Baca <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
