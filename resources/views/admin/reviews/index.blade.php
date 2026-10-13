@extends('layouts.admin')

@section('title', 'Kelola Ulasan Tamu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Ulasan Tamu & Testimoni</h3>
        <p class="text-muted small mb-0">Kelola ulasan tamu terverifikasi dari Google Reviews, SENTEC, dan reservasi langsung.</p>
    </div>
    <button type="button" class="btn btn-ubu-primary" data-bs-toggle="modal" data-bs-target="#createReviewModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Ulasan Tamu
    </button>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Tamu</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Properti / Brand</th>
                    <th>Sumber</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-end pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $rev)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $rev->guest_name }}</div>
                            <div class="text-muted small">{{ $rev->guest_origin ?? 'Indonesia' }}</div>
                        </td>
                        <td>
                            <div class="text-warning small text-nowrap">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $rev->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <div class="small text-truncate" style="max-width: 280px;" title="{{ $rev->review_text_id }}">
                                {{ $rev->review_text_id }}
                            </div>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $rev->property->name ?? ($rev->brand->name ?? 'Semua') }}</div>
                        </td>
                        <td>
                            @php
                                $srcBadge = match($rev->source) {
                                    'google' => 'bg-danger-subtle text-danger',
                                    'sentec' => 'bg-primary-subtle text-primary',
                                    default => 'bg-secondary-subtle text-secondary'
                                };
                            @endphp
                            <span class="badge {{ $srcBadge }} text-uppercase" style="font-size: 0.7rem;">
                                {{ $rev->source }}
                            </span>
                            @if($rev->is_verified)
                                <i class="bi bi-patch-check-fill text-primary ms-1" title="Terverifikasi"></i>
                            @endif
                        </td>
                        <td>
                            @if($rev->status === 'published')
                                <span class="badge bg-success-subtle text-success">Published</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-muted">{{ $rev->review_date ? $rev->review_date->format('d/m/Y') : '-' }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $rev->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.reviews.destroy', $rev) }}" method="POST" onsubmit="return confirm('Hapus ulasan tamu ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade text-start" id="editReviewModal{{ $rev->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-serif">Edit Ulasan Tamu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.reviews.update', $rev) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small">Nama Tamu <span class="text-danger">*</span></label>
                                                    <input type="text" name="guest_name" class="form-control" value="{{ $rev->guest_name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Asal Tamu / Kota</label>
                                                    <input type="text" name="guest_origin" class="form-control" value="{{ $rev->guest_origin }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Properti Terkait</label>
                                                    <select name="property_id" class="form-select">
                                                        <option value="">-- Tidak Terikat Properti Spesifik --</option>
                                                        @foreach($properties as $p)
                                                            <option value="{{ $p->id }}" {{ $rev->property_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small">Rating Bintang <span class="text-danger">*</span></label>
                                                    <select name="rating" class="form-select" required>
                                                        @for($s = 5; $s >= 1; $s--)
                                                            <option value="{{ $s }}" {{ $rev->rating == $s ? 'selected' : '' }}>{{ $s }} Bintang</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label small">Sumber Ulasan</label>
                                                    <select name="source" class="form-select" required>
                                                        <option value="google" {{ $rev->source === 'google' ? 'selected' : '' }}>Google Reviews</option>
                                                        <option value="sentec" {{ $rev->source === 'sentec' ? 'selected' : '' }}>SENTEC Booking</option>
                                                        <option value="direct" {{ $rev->source === 'direct' ? 'selected' : '' }}>Direct Website</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">Isi Ulasan (Indonesia) <span class="text-danger">*</span></label>
                                                    <textarea name="review_text_id" rows="3" class="form-control" required>{{ $rev->review_text_id }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">Isi Ulasan (Inggris)</label>
                                                    <textarea name="review_text_en" rows="3" class="form-control">{{ $rev->review_text_en }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Tanggal Ulasan <span class="text-danger">*</span></label>
                                                    <input type="date" name="review_date" class="form-control" value="{{ $rev->review_date ? $rev->review_date->format('Y-m-d') : date('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Status Publikasi</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="published" {{ $rev->status === 'published' ? 'selected' : '' }}>Published (Tampil)</option>
                                                        <option value="hidden" {{ $rev->status === 'hidden' ? 'selected' : '' }}>Hidden (Sembunyikan)</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 d-flex gap-4">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="editVer{{ $rev->id }}" {{ $rev->is_verified ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="editVer{{ $rev->id }}">Verified Guest</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="editFeat{{ $rev->id }}" {{ $rev->is_featured ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="editFeat{{ $rev->id }}">Tampilkan di Beranda (Featured)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-ubu-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Belum ada ulasan tamu yang tersimpan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div class="p-3 border-top">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

<!-- Modal Create Review -->
<div class="modal fade" id="createReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-serif">Tambah Ulasan Tamu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reviews.store') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label small">Nama Tamu <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" class="form-control" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Asal Kota / Negara</label>
                        <input type="text" name="guest_origin" class="form-control" placeholder="Contoh: Jakarta Selatan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Properti Terkait</label>
                        <select name="property_id" class="form-select">
                            <option value="">-- Pustaka Ulasan Umum --</option>
                            @foreach($properties as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Rating Bintang <span class="text-danger">*</span></label>
                        <select name="rating" class="form-select" required>
                            <option value="5" selected>5 Bintang (Sempurna)</option>
                            <option value="4">4 Bintang (Sangat Bagus)</option>
                            <option value="3">3 Bintang (Cukup)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Sumber</label>
                        <select name="source" class="form-select" required>
                            <option value="google" selected>Google Reviews</option>
                            <option value="sentec">SENTEC Booking</option>
                            <option value="direct">Direct Website</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Isi Testimoni (Indonesia) <span class="text-danger">*</span></label>
                        <textarea name="review_text_id" rows="3" class="form-control" required placeholder="Tuliskan ulasan jujur tamu..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Isi Testimoni (Inggris)</label>
                        <textarea name="review_text_en" rows="3" class="form-control" placeholder="English version review..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Tanggal Review <span class="text-danger">*</span></label>
                        <input type="date" name="review_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="published" selected>Published (Tampilkan)</option>
                            <option value="hidden">Hidden (Sembunyikan)</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="newVer" checked>
                            <label class="form-check-label small" for="newVer">Verified Guest</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="newFeat" checked>
                            <label class="form-check-label small" for="newFeat">Tampilkan di Beranda (Featured)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary">Simpan Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
