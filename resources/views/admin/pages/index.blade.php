@extends('layouts.admin')

@section('title', 'Kelola Halaman & Konten Statis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Daftar Halaman & Konten Statis</h3>
        <p class="text-muted small mb-0">Kelola narasi About Us, FAQ, Kebijakan Privasi, Kontak, dan seksi konten website.</p>
    </div>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Halaman</th>
                    <th>Slug URL</th>
                    <th>Jumlah Seksi Modular</th>
                    <th>Status</th>
                    <th>Terakhir Diperbarui</th>
                    <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $page->title_id }}</div>
                            <div class="text-muted small">{{ $page->title_en }}</div>
                        </td>
                        <td>
                            <code class="text-muted">/{{ $page->slug }}</code>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $page->sections_count }} Seksi</span>
                        </td>
                        <td>
                            @if($page->status === 'published')
                                <span class="badge bg-success-subtle text-success">Published</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-muted">{{ $page->updated_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil me-1"></i> Edit Konten
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            Belum ada halaman yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
