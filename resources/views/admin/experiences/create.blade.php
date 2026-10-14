@extends('layouts.admin')

@section('title', 'Tambah Experience Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Tambah Experience Baru</h3>
        <p class="text-muted small mb-0">Tambahkan paket kegiatan tamu seperti floating breakfast, barbecue night, spa, atau tur lokal.</p>
    </div>
    <a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Judul Aktivitas (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id') }}" required placeholder="Contoh: Floating Breakfast Romantic">
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Judul Aktivitas (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required placeholder="Romantic Floating Breakfast">
            </div>

            <div class="col-md-4">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="culinary">Kuliner & Dining</option>
                    <option value="wellness">Wellness & Spa</option>
                    <option value="adventure">Petualangan & Outdoor</option>
                    <option value="family">Keluarga & Anak</option>
                    <option value="culture">Budaya & Seni</option>
                    <option value="meeting">Meeting & Gathering</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Terkait Brand (Opsional)</label>
                <select name="brand_id" class="form-select">
                    <option value="">Semua Brand (Universal)</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Terkait Properti Spesifik (Opsional)</label>
                <select name="property_id" class="form-select">
                    <option value="">Semua Properti</option>
                    @foreach($properties as $p)
                        <option value="{{ $p->id }}" {{ old('property_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Harga Display / Tarif</label>
                <input type="text" name="price_display" class="form-control" value="{{ old('price_display', 'Rp 250.000 / couple') }}" placeholder="Contoh: Mulai Rp 150.000 / pax atau Complimentary">
            </div>
            <div class="col-md-6">
                <label class="form-label">Lokasi / Keterangan Area</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', 'Yogyakarta Area') }}" placeholder="Contoh: Private Pool Villa atau Sleman Area">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Foto Utama</label>
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 5MB. Disimpan otomatis tanpa storage:link.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Foto Utama (Alternatif)</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image') }}" placeholder="https://...">
            </div>

            <div class="col-md-6">
                <label class="form-label">Deskripsi Singkat (Indonesia)</label>
                <textarea name="short_description_id" rows="2" class="form-control">{{ old('short_description_id') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deskripsi Singkat (Inggris)</label>
                <textarea name="short_description_en" rows="2" class="form-control">{{ old('short_description_en') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Konten Lengkap / Cara Reservasi (Indonesia)</label>
                <textarea name="content_id" rows="4" class="form-control">{{ old('content_id') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Konten Lengkap (Inggris)</label>
                <textarea name="content_en" rows="4" class="form-control">{{ old('content_en') }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Slug URL (Opsional)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Otomatis dari judul jika kosong">
            </div>
            <div class="col-md-4">
                <label class="form-label">Urutan Tampilan</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="published" selected>Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Experience
            </button>
        </div>
    </form>
</div>
@endsection
