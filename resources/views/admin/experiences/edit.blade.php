@extends('layouts.admin')

@section('title', 'Edit Experience: ' . $experience->title_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Experience</h3>
        <p class="text-muted small mb-0">Perbarui informasi aktivitas tamu, tarif display, atau foto pendukung.</p>
    </div>
    <a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.experiences.update', $experience) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Judul Aktivitas (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id', $experience->title_id) }}" required>
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Judul Aktivitas (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $experience->title_en) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="culinary" {{ old('category', $experience->category) == 'culinary' ? 'selected' : '' }}>Kuliner & Dining</option>
                    <option value="wellness" {{ old('category', $experience->category) == 'wellness' ? 'selected' : '' }}>Wellness & Spa</option>
                    <option value="adventure" {{ old('category', $experience->category) == 'adventure' ? 'selected' : '' }}>Petualangan & Outdoor</option>
                    <option value="family" {{ old('category', $experience->category) == 'family' ? 'selected' : '' }}>Keluarga & Anak</option>
                    <option value="culture" {{ old('category', $experience->category) == 'culture' ? 'selected' : '' }}>Budaya & Seni</option>
                    <option value="meeting" {{ old('category', $experience->category) == 'meeting' ? 'selected' : '' }}>Meeting & Gathering</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Terkait Brand (Opsional)</label>
                <select name="brand_id" class="form-select">
                    <option value="">Semua Brand (Universal)</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ old('brand_id', $experience->brand_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Terkait Properti Spesifik (Opsional)</label>
                <select name="property_id" class="form-select">
                    <option value="">Semua Properti</option>
                    @foreach($properties as $p)
                        <option value="{{ $p->id }}" {{ old('property_id', $experience->property_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Harga Display / Tarif</label>
                <input type="text" name="price_display" class="form-control" value="{{ old('price_display', $experience->price_display) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Lokasi / Keterangan Area</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $experience->location) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Ganti Foto Utama (Upload Baru)</label>
                @if($experience->featured_image)
                    <div class="mb-2 d-flex align-items-center gap-2 p-2 border rounded bg-light">
                        <img src="{{ image_or_default($experience->featured_image) }}" alt="Preview" class="rounded object-fit-cover" style="width: 80px; height: 50px;">
                        <span class="small text-muted text-truncate" style="max-width: 250px;">{{ basename($experience->featured_image) }}</span>
                    </div>
                @endif
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Upload gambar baru untuk mengganti foto utama.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Foto Utama (Alternatif)</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $experience->featured_image) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Deskripsi Singkat (Indonesia)</label>
                <textarea name="short_description_id" rows="2" class="form-control">{{ old('short_description_id', $experience->short_description_id) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deskripsi Singkat (Inggris)</label>
                <textarea name="short_description_en" rows="2" class="form-control">{{ old('short_description_en', $experience->short_description_en) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Konten Lengkap / Cara Reservasi (Indonesia)</label>
                <textarea name="content_id" rows="4" class="form-control">{{ old('content_id', $experience->content_id) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Konten Lengkap (Inggris)</label>
                <textarea name="content_en" rows="4" class="form-control">{{ old('content_en', $experience->content_en) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Slug URL</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $experience->slug) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Urutan Tampilan</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $experience->sort_order) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ old('status', $experience->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $experience->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Perbarui Experience
            </button>
        </div>
    </form>
</div>
@endsection
