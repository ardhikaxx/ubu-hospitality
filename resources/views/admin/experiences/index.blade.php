@extends('layouts.admin')

@section('title', 'Kelola Experiences')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Daftar Aktivitas & Experience</h3>
        <p class="text-muted small mb-0">Kelola katalog pengalaman hospitality, wellness, kuliner, dan aktivitas tamu.</p>
    </div>
    <a href="{{ route('admin.experiences.create') }}" class="btn btn-ubu-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Experience
    </a>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Judul & Kategori</th>
                    <th>Brand / Properti</th>
                    <th>Harga Display</th>
                    <th>Status</th>
                    <th>Urutan</th>
                    <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($experiences as $exp)
                    <tr>
                        <td>
                            @if($exp->featured_image)
                                <img src="{{ $exp->featured_image }}" alt="{{ $exp->title_id }}" class="rounded object-fit-cover" width="60" height="45">
                            @else
                                <div class="bg-light rounded text-muted d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $exp->title_id }}</div>
                            <div class="text-muted small">{{ $exp->title_en }}</div>
                            <span class="badge bg-light text-dark border mt-1">{{ ucfirst($exp->category) }}</span>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $exp->brand->name ?? 'Semua Brand' }}</div>
                            <div class="text-muted small">{{ $exp->property->name ?? ($exp->location ?? '-') }}</div>
                        </td>
                        <td>
                            <span class="small font-monospace">{{ $exp->price_display ?? 'Gratis / Include' }}</span>
                        </td>
                        <td>
                            @if($exp->status === 'published')
                                <span class="badge bg-success-subtle text-success">Published</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">{{ $exp->sort_order }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus experience ini?');" class="d-inline">
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
                            <i class="bi bi-compass display-6 d-block mb-2"></i>
                            Belum ada aktivitas / experience yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($experiences->hasPages())
        <div class="p-3 border-top">
            {{ $experiences->links() }}
        </div>
    @endif
</div>
@endsection
