@extends('layouts.admin')

@section('title', 'Buat Promo Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Buat Promo Baru</h3>
        <p class="text-muted small mb-0">Tentukan kode kupon, besaran potongan, periode booking dan menginap, serta target properti.</p>
    </div>
    <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Kode Kupon (Voucher) <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control text-uppercase font-monospace fw-bold @error('code') is-invalid @enderror" value="{{ old('code') }}" required placeholder="Contoh: UBUHEMAT20">
                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Diskon <span class="text-danger">*</span></label>
                <select name="discount_type" class="form-select" required>
                    <option value="percentage">Persentase (%)</option>
                    <option value="fixed_amount">Nominal Tetap (Rp)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
                <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value', 15) }}" required min="1">
            </div>

            <div class="col-md-6">
                <label class="form-label">Judul Promo (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id') }}" required placeholder="Contoh: Diskon Staycation Awal Tahun 15%">
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Judul Promo (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required placeholder="New Year Staycation 15% OFF">
            </div>

            <div class="col-md-6">
                <label class="form-label">Subjudul Singkat</label>
                <input type="text" name="subtitle_id" class="form-control" value="{{ old('subtitle_id') }}" placeholder="Nikmati liburan lebih hemat di seluruh villa Ubu">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Banner Promo</label>
                <input type="file" name="banner_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 5MB. Disimpan otomatis tanpa storage:link.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Banner Promo (Alternatif)</label>
                <input type="text" name="banner_image" class="form-control" value="{{ old('banner_image') }}" placeholder="https://...">
            </div>

            <!-- Date Periods -->
            <div class="col-md-3">
                <label class="form-label">Mulai Periode Booking <span class="text-danger">*</span></label>
                <input type="date" name="booking_period_start" class="form-control" value="{{ old('booking_period_start', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Akhir Periode Booking <span class="text-danger">*</span></label>
                <input type="date" name="booking_period_end" class="form-control" value="{{ old('booking_period_end', date('Y-m-d', strtotime('+3 months'))) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mulai Periode Menginap <span class="text-danger">*</span></label>
                <input type="date" name="stay_period_start" class="form-control" value="{{ old('stay_period_start', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Akhir Periode Menginap <span class="text-danger">*</span></label>
                <input type="date" name="stay_period_end" class="form-control" value="{{ old('stay_period_end', date('Y-m-d', strtotime('+6 months'))) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Syarat & Ketentuan Promo</label>
                <textarea name="terms_conditions_id" rows="3" class="form-control">{{ old('terms_conditions_id', "1. Berlaku untuk pemesanan langsung melalui situs resmi.\n2. Tidak dapat digabungkan dengan promo lainnya.\n3. Minimal menginap 1 malam.") }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Cakupan Brand Tertentu (Kosongkan jika semua)</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($brands as $b)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="brand_ids[]" value="{{ $b->id }}" id="brandCheck{{ $b->id }}">
                            <label class="form-check-label small" for="brandCheck{{ $b->id }}">{{ $b->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Prioritas Tampilan</label>
                <input type="number" name="priority" class="form-control" value="{{ old('priority', 5) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="published" selected>Published (Aktif)</option>
                    <option value="draft">Draft (Draf)</option>
                    <option value="expired">Expired (Berakhir)</option>
                </select>
            </div>

            <div class="col-12 d-flex gap-4 pt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_new_user_only" value="1" id="isNewUser">
                    <label class="form-check-label small fw-semibold" for="isNewUser">Khusus Tamu Baru (First Booking)</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_popup" value="1" id="isPopup">
                    <label class="form-check-label small fw-semibold" for="isPopup">Tampilkan Sebagai Pop-Up Banner di Beranda</label>
                </div>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Promo
            </button>
        </div>
    </form>
</div>
@endsection
