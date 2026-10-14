@extends('layouts.admin')

@section('title', 'Edit Promo: ' . $promotion->code)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Promo: {{ $promotion->code }}</h3>
        <p class="text-muted small mb-0">Perbarui konfigurasi kode voucher, besaran diskon, atau periode penawaran.</p>
    </div>
    <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Kode Kupon (Voucher) <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control text-uppercase font-monospace fw-bold @error('code') is-invalid @enderror" value="{{ old('code', $promotion->code) }}" required>
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Diskon <span class="text-danger">*</span></label>
                <select name="discount_type" class="form-select" required>
                    <option value="percentage" {{ old('discount_type', $promotion->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed_amount" {{ old('discount_type', $promotion->discount_type) == 'fixed_amount' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
                <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value', $promotion->discount_value) }}" required min="1">
            </div>

            <div class="col-md-6">
                <label class="form-label">Judul Promo (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id', $promotion->title_id) }}" required>
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Judul Promo (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $promotion->title_en) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Subjudul Singkat</label>
                <input type="text" name="subtitle_id" class="form-control" value="{{ old('subtitle_id', $promotion->subtitle_id) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Ganti Banner Promo (Upload Baru)</label>
                @if($promotion->banner_image)
                    <div class="mb-2 d-flex align-items-center gap-2 p-2 border rounded bg-light">
                        <img src="{{ image_or_default($promotion->banner_image) }}" alt="Preview" class="rounded object-fit-cover" style="width: 80px; height: 50px;">
                        <span class="small text-muted text-truncate" style="max-width: 250px;">{{ basename($promotion->banner_image) }}</span>
                    </div>
                @endif
                <input type="file" name="banner_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Upload foto baru untuk mengganti banner promo.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Banner Gambar (Alternatif)</label>
                <input type="text" name="banner_image" class="form-control" value="{{ old('banner_image', $promotion->banner_image) }}">
            </div>

            <!-- Date Periods -->
            <div class="col-md-3">
                <label class="form-label">Mulai Periode Booking <span class="text-danger">*</span></label>
                <input type="date" name="booking_period_start" class="form-control" value="{{ old('booking_period_start', $promotion->booking_period_start ? \Carbon\Carbon::parse($promotion->booking_period_start)->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Akhir Periode Booking <span class="text-danger">*</span></label>
                <input type="date" name="booking_period_end" class="form-control" value="{{ old('booking_period_end', $promotion->booking_period_end ? \Carbon\Carbon::parse($promotion->booking_period_end)->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mulai Periode Menginap <span class="text-danger">*</span></label>
                <input type="date" name="stay_period_start" class="form-control" value="{{ old('stay_period_start', $promotion->stay_period_start ? \Carbon\Carbon::parse($promotion->stay_period_start)->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Akhir Periode Menginap <span class="text-danger">*</span></label>
                <input type="date" name="stay_period_end" class="form-control" value="{{ old('stay_period_end', $promotion->stay_period_end ? \Carbon\Carbon::parse($promotion->stay_period_end)->format('Y-m-d') : '') }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Syarat & Ketentuan Promo</label>
                <textarea name="terms_conditions_id" rows="3" class="form-control">{{ old('terms_conditions_id', $promotion->terms_conditions_id) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Cakupan Brand Tertentu (Kosongkan jika semua)</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($brands as $b)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="brand_ids[]" value="{{ $b->id }}" id="brandCheck{{ $b->id }}" {{ in_array($b->id, old('brand_ids', $selectedBrands)) ? 'checked' : '' }}>
                            <label class="form-check-label small" for="brandCheck{{ $b->id }}">{{ $b->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Prioritas Tampilan</label>
                <input type="number" name="priority" class="form-control" value="{{ old('priority', $promotion->priority) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ old('status', $promotion->status) == 'published' ? 'selected' : '' }}>Published (Aktif)</option>
                    <option value="draft" {{ old('status', $promotion->status) == 'draft' ? 'selected' : '' }}>Draft (Draf)</option>
                    <option value="expired" {{ old('status', $promotion->status) == 'expired' ? 'selected' : '' }}>Expired (Berakhir)</option>
                </select>
            </div>

            <div class="col-12 d-flex gap-4 pt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_new_user_only" value="1" id="isNewUser" {{ old('is_new_user_only', $promotion->is_new_user_only) ? 'checked' : '' }}>
                    <label class="form-check-label small fw-semibold" for="isNewUser">Khusus Tamu Baru (First Booking)</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_popup" value="1" id="isPopup" {{ old('is_popup', $promotion->is_popup) ? 'checked' : '' }}>
                    <label class="form-check-label small fw-semibold" for="isPopup">Tampilkan Sebagai Pop-Up Banner di Beranda</label>
                </div>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Perbarui Promo
            </button>
        </div>
    </form>
</div>
@endsection
