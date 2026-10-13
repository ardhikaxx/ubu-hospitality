@extends('layouts.admin')

@section('title', 'Tambah Brand Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Tambah Brand Baru</h3>
        <p class="text-muted small mb-0">Daftarkan brand baru ke dalam portfolio Ubu Hospitality.</p>
    </div>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nama Brand <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Ubu Villa">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Karakter / Positioning <span class="text-danger">*</span></label>
                <select name="positioning_type" class="form-select @error('positioning_type') is-invalid @enderror" required>
                    <option value="luxury">Luxury Tropical Private Sanctuary</option>
                    <option value="syariah">Syariah Compliant (Buruj Family Halal)</option>
                    <option value="glamping">Glamping & Nature Escape</option>
                    <option value="standard">Standard Hospitality</option>
                </select>
                @error('positioning_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline (Indonesia)</label>
                <input type="text" name="tagline_id" class="form-control" value="{{ old('tagline_id') }}" placeholder="Private Sanctuary of Warmth & Elegance">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline (Inggris)</label>
                <input type="text" name="tagline_en" class="form-control" value="{{ old('tagline_en') }}">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Ringkas</label>
                <textarea name="description_id" rows="2" class="form-control">{{ old('description_id') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Kisah & Filosofi Brand (Story)</label>
                <textarea name="story_id" rows="4" class="form-control">{{ old('story_id') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Poin Karakter / Nilai Utama (1 baris per poin)</label>
                <textarea name="character_highlights_raw" rows="3" class="form-control" placeholder="Kolam Renang Privat Eksklusif&#10;Layanan Floating Breakfast&#10;Kehangatan Layanan 24 Jam">{{ old('character_highlights_raw') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Foto Cover / Banner</label>
                <input type="text" name="cover_image_path" class="form-control" value="{{ old('cover_image_path') }}" placeholder="https://images.unsplash.com/...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Warna Aksen Utama (HEX)</label>
                <input type="color" name="accent_color" class="form-control form-control-color w-100" value="{{ old('accent_color', '#1b3b2b') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Warna Sekunder (HEX)</label>
                <input type="color" name="secondary_color" class="form-control form-control-color w-100" value="{{ old('secondary_color', '#c5a059') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Urutan Tampil (Sort Order)</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                    <label class="form-check-label fw-bold small" for="isActive">Publikasikan Brand Ini</label>
                </div>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Brand Baru
            </button>
        </div>
    </form>
</div>
@endsection
