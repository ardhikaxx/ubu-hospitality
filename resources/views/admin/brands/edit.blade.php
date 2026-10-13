@extends('layouts.admin')

@section('title', 'Edit Brand - ' . $brand->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Brand: {{ $brand->name }}</h3>
        <p class="text-muted small mb-0">Perbarui identitas, deskripsi bilingual, dan karakter visual brand.</p>
    </div>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nama Brand <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug URL <span class="text-danger">*</span></label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $brand->slug) }}" required>
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Karakter / Positioning <span class="text-danger">*</span></label>
                <select name="positioning_type" class="form-select @error('positioning_type') is-invalid @enderror" required>
                    <option value="luxury" {{ $brand->positioning_type === 'luxury' ? 'selected' : '' }}>Luxury Tropical Private Sanctuary</option>
                    <option value="syariah" {{ $brand->positioning_type === 'syariah' ? 'selected' : '' }}>Syariah Compliant (Buruj Family Halal)</option>
                    <option value="glamping" {{ $brand->positioning_type === 'glamping' ? 'selected' : '' }}>Glamping & Nature Escape</option>
                    <option value="standard" {{ $brand->positioning_type === 'standard' ? 'selected' : '' }}>Standard Hospitality</option>
                </select>
                @error('positioning_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline (Indonesia)</label>
                <input type="text" name="tagline_id" class="form-control" value="{{ old('tagline_id', $brand->tagline_id) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Ringkas</label>
                <textarea name="description_id" rows="2" class="form-control">{{ old('description_id', $brand->description_id) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Kisah & Filosofi Brand (Story)</label>
                <textarea name="story_id" rows="4" class="form-control">{{ old('story_id', $brand->story_id) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Poin Karakter / Nilai Utama (1 baris per poin)</label>
                <textarea name="character_highlights_raw" rows="3" class="form-control">{{ old('character_highlights_raw', implode("\n", $brand->character_highlights ?? [])) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Foto Cover / Banner</label>
                <input type="text" name="cover_image_path" class="form-control" value="{{ old('cover_image_path', $brand->cover_image_path) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Warna Aksen Utama</label>
                <input type="color" name="accent_color" class="form-control form-control-color w-100" value="{{ old('accent_color', $brand->accent_color) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Warna Sekunder</label>
                <input type="color" name="secondary_color" class="form-control form-control-color w-100" value="{{ old('secondary_color', $brand->secondary_color) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $brand->sort_order) }}">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ $brand->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isActive">Status Aktif / Terpublikasi</label>
                </div>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Perubahan Brand
            </button>
        </div>
    </form>
</div>
@endsection
