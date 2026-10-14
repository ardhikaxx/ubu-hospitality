@extends('layouts.admin')

@section('title', 'Manajemen Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Manajemen Brand</h3>
        <p class="text-muted small mb-0">Kelola master brand Ubu Hospitality dan brand portofolio anak (Ubu Villa, Buruj Villa, Glamping).</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-ubu-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Brand Baru
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="{{ route('admin.brands.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama brand..." value="{{ request('q') }}" style="width: 250px;">
            <button class="btn btn-sm btn-dark" type="submit">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Logo / Cover</th>
                    <th>Nama Brand</th>
                    <th>Karakter / Positioning</th>
                    <th>Jumlah Properti</th>
                    <th>Warna Aksen</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($brands as $b)
                    <tr>
                        <td style="width: 80px;">
                            <img src="{{ image_or_default($b->cover_image_path) }}" alt="{{ $b->name }}" class="rounded-2" style="width: 70px; height: 45px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/default-img.png') }}';">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $b->name }}</div>
                            <small class="text-muted font-monospace">{{ $b->slug }}</small>
                        </td>
                        <td>
                            @if($b->positioning_type === 'syariah')
                                <span class="badge-syariah"><i class="bi bi-shield-check"></i> Syariah</span>
                            @else
                                <span class="badge bg-light text-dark border">{{ ucfirst($b->positioning_type) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-dark">{{ $b->properties_count }} Properti</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-block rounded-circle" style="width: 16px; height: 16px; background-color: {{ $b->accent_color }};"></span>
                                <small class="font-monospace">{{ $b->accent_color }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $b->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.brands.edit', $b->id) }}" class="btn btn-sm btn-light border py-1 px-2 text-dark">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.brands.destroy', $b->id) }}" method="POST" class="d-inline" id="deleteBrand{{ $b->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="confirmDelete('deleteBrand{{ $b->id }}', 'Apakah Anda yakin ingin menghapus brand {{ $b->name }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada brand terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($brands->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $brands->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
