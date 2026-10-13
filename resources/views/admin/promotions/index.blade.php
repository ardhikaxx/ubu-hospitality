@extends('layouts.admin')

@section('title', 'Manajemen Promo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Manajemen Promo & Penawaran</h3>
        <p class="text-muted small mb-0">Kelola kupon diskon, periode booking vs stay, target brand, dan konfigurasi popup promo.</p>
    </div>
    <a href="{{ route('admin.promotions.create') }}" class="btn btn-ubu-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Buat Promo Baru
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Kode Kupon</th>
                    <th>Judul Promo</th>
                    <th>Diskon</th>
                    <th>Periode Booking</th>
                    <th>Periode Menginap</th>
                    <th>Cakupan Brand</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promo)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace fw-bold fs-6">{{ $promo->code }}</span>
                            @if($promo->is_popup) <div class="badge bg-warning text-dark mt-1" style="font-size: 0.65rem;">Popup Aktif</div> @endif
                            @if($promo->is_new_user_only) <div class="badge bg-info text-dark mt-1" style="font-size: 0.65rem;">Tamu Baru</div> @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $promo->title_id }}</div>
                            <small class="text-muted">{{ $promo->subtitle_id }}</small>
                        </td>
                        <td>
                            <span class="badge bg-danger fs-6">{{ $promo->discount_label }}</span>
                        </td>
                        <td class="small text-muted">
                            <div>{{ $promo->booking_period_start->format('d M Y') }}</div>
                            <div>s/d {{ $promo->booking_period_end->format('d M Y') }}</div>
                        </td>
                        <td class="small text-muted">
                            <div>{{ $promo->stay_period_start->format('d M Y') }}</div>
                            <div>s/d {{ $promo->stay_period_end->format('d M Y') }}</div>
                        </td>
                        <td>
                            @forelse($promo->brands as $pb)
                                <span class="badge bg-dark small">{{ $pb->name }}</span>
                            @empty
                                <span class="badge bg-secondary small">Semua Brand</span>
                            @endforelse
                        </td>
                        <td>
                            <span class="badge {{ $promo->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($promo->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-light border py-1 px-2 text-dark">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline" id="deletePromo{{ $promo->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="confirmDelete('deletePromo{{ $promo->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada promo terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($promotions->hasPages())
        <div class="p-3 border-top d-flex justify-content-center">
            {{ $promotions->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
