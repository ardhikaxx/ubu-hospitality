@extends('layouts.admin')

@section('title', 'Manajemen Artikel & Inspirasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Artikel & Panduan Perjalanan</h3>
        <p class="text-muted small mb-0">Kelola konten storytelling, travel guide, inspirasi staycation, dan publikasi SEO.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-ubu-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Artikel Baru
    </a>
</div>

<!-- Search & Filter -->
<div class="admin-card p-3 mb-4">
    <form action="{{ route('admin.blog.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="Cari judul artikel..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name_id }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">Filter</button>
            @if(request()->hasAny(['q', 'category_id']))
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Cover</th>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tanggal Terbit</th>
                    <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            @if($post->featured_image)
                                <img src="{{ image_or_default($post->featured_image) }}" alt="{{ $post->title_id }}" class="rounded object-fit-cover" width="60" height="45" onerror="this.onerror=null;this.src='{{ asset('images/default-img.png') }}';">
                            @else
                                <div class="bg-light rounded text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                    <i class="bi bi-file-text"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $post->title_id }}</div>
                            <div class="text-muted small">
                                <span class="me-2"><i class="bi bi-clock"></i> {{ $post->reading_time_minutes }} mnt baca</span>
                                <span><i class="bi bi-eye"></i> {{ number_format($post->views_count) }} views</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $post->category->name_id ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="small">{{ $post->author->name ?? 'Admin' }}</span>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span class="badge bg-success-subtle text-success">Published</span>
                            @elseif($post->status === 'scheduled')
                                <span class="badge bg-info-subtle text-info">Scheduled</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-muted">
                                {{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline-secondary" title="Lihat di Web">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-richtext display-6 d-block mb-2"></i>
                            Belum ada artikel yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
        <div class="p-3 border-top">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
