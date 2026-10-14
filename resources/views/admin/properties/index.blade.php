@extends('layouts.admin')

@section('title', 'Manajemen Properti')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Manajemen Properti</h3>
        <p class="text-muted small mb-0">Kelola katalog unit villa, glamping, tautan SENTEC ID, fasilitas, dan status publikasi.</p>
    </div>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-ubu-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Properti Baru
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <form action="{{ route('admin.properties.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari properti / SENTEC ID..." value="{{ request('q') }}" style="width: 250px;">
            <select name="brand_id" class="form-select form-select-sm" style="width: 180px;">
                <option value="">Semua Brand</option>
                @foreach($brands as $b)
                    <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            <button class="btn btn-sm btn-dark" type="submit">Filter</button>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Properti</th>
                    <th>Brand & Tipe</th>
                    <th>SENTEC Property ID</th>
                    <th>Kapasitas</th>
                    <th>Tarif Mulai</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $prop)
                    <tr>
                        <td style="width: 80px;">
                            <img src="{{ image_or_default($prop->featured_image) }}" alt="{{ $prop->name }}" class="rounded-2" style="width: 70px; height: 45px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('images/default-img.png') }}';">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $prop->name }}</div>
                            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $prop->city }}</small>
                            <div class="mt-1">
                                @if($prop->is_featured) <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Featured</span> @endif
                                @if($prop->is_syariah) <span class="badge bg-dark text-warning" style="font-size: 0.65rem;">Syariah</span> @endif
                                @if($prop->has_private_pool) <span class="badge bg-primary" style="font-size: 0.65rem;">Private Pool</span> @endif
                            </div>
                        </td>
                        <td>
                            <div class="small fw-semibold text-dark">{{ $prop->brand?->name }}</div>
                            <small class="text-muted">{{ $prop->propertyType?->name }}</small>
                        </td>
                        <td>
                            @if($prop->sentec_property_id)
                                <span class="badge bg-success-subtle text-success font-monospace">{{ $prop->sentec_property_id }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary small">Belum Terhubung</span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            <div><i class="bi bi-people"></i> {{ $prop->max_guests }} Tamu</div>
                            <div><i class="bi bi-door-closed"></i> {{ $prop->bedrooms }} Kamar</div>
                        </td>
                        <td class="fw-bold text-success">
                            {{ $prop->formatted_price }}
                        </td>
                        <td>
                            <span class="badge {{ $prop->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($prop->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('stay.show', $prop->slug) }}" target="_blank" class="btn btn-sm btn-light border py-1 px-2 text-dark" title="Lihat di Web">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <a href="{{ route('admin.properties.edit', $prop->id) }}" class="btn btn-sm btn-light border py-1 px-2 text-dark" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.properties.destroy', $prop->id) }}" method="POST" class="d-inline" id="deleteProp{{ $prop->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="confirmDelete('deleteProp{{ $prop->id }}', 'Apakah Anda yakin ingin menghapus properti {{ $prop->name }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada properti terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($properties->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
