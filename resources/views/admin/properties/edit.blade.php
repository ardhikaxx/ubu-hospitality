@extends('layouts.admin')

@section('title', 'Edit Properti - ' . $property->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Properti: {{ $property->name }}</h3>
        <p class="text-muted small mb-0">Perbarui informasi, integrasi SENTEC ID, fasilitas, dan foto properti.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stay.show', $property->slug) }}" target="_blank" class="btn btn-outline-success btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau di Web
        </a>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.properties.update', $property->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">1. Informasi Pokok & Brand</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nama Properti <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $property->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug URL <span class="text-danger">*</span></label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $property->slug) }}" required>
                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Brand <span class="text-danger">*</span></label>
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ old('brand_id', $property->brand_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipe Properti <span class="text-danger">*</span></label>
                <select name="property_type_id" class="form-select @error('property_type_id') is-invalid @enderror" required>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->id }}" {{ old('property_type_id', $property->property_type_id) == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kota / Area <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $property->city) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Destinasi Utama</label>
                <select name="destination_id" class="form-select">
                    <option value="">Pilih Area</option>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}" {{ old('destination_id', $property->destination_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Headline / Ringkasan Daya Tarik</label>
                <input type="text" name="headline_id" class="form-control" value="{{ old('headline_id', $property->headline_id) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Alamat Lengkap</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $property->address) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea name="description_id" rows="4" class="form-control @error('description_id') is-invalid @enderror" required>{{ old('description_id', $property->description_id) }}</textarea>
                @error('description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">2. Integrasi SENTEC & Spesifikasi Kapasitas</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">SENTEC Property ID</label>
                <input type="text" name="sentec_property_id" class="form-control font-monospace @error('sentec_property_id') is-invalid @enderror" value="{{ old('sentec_property_id', $property->sentec_property_id) }}">
                <small class="text-muted" style="font-size: 0.75rem;">Kode penghubung ketersediaan dan tarif real-time SENTEC.</small>
                @error('sentec_property_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Tarif Mulai Dari (Estimasi Tampilan) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="starting_price_display" class="form-control @error('starting_price_display') is-invalid @enderror" value="{{ old('starting_price_display', (int) $property->starting_price_display) }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ $property->status === 'published' ? 'selected' : '' }}>Published (Terbit di Web)</option>
                    <option value="draft" {{ $property->status === 'draft' ? 'selected' : '' }}>Draft (Draf Internal)</option>
                    <option value="archived" {{ $property->status === 'archived' ? 'selected' : '' }}>Archived (Diarsipkan)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kapasitas Maksimal Tamu <span class="text-danger">*</span></label>
                <input type="number" name="max_guests" class="form-control" value="{{ old('max_guests', $property->max_guests) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah Kamar Tidur <span class="text-danger">*</span></label>
                <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms', $property->bedrooms) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah Kamar Mandi <span class="text-danger">*</span></label>
                <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms', $property->bathrooms) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Luas Bangunan (m²)</label>
                <input type="number" name="area_sqm" class="form-control" value="{{ old('area_sqm', $property->area_sqm) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Kasur</label>
                <input type="text" name="beds_description" class="form-control" value="{{ old('beds_description', $property->beds_description) }}">
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">3. Fasilitas & Fitur Khusus</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="has_private_pool" value="1" id="hasPool" {{ $property->has_private_pool ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="hasPool">Memiliki Private Swimming Pool</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_syariah" value="1" id="isSyariah" {{ $property->is_syariah ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isSyariah">Standar Syariah Compliant (Buruj)</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ $property->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isFeatured">Tampilkan di Pilihan Unggulan (Featured)</label>
                </div>
            </div>

            <div class="col-12 mt-3">
                <label class="form-label fw-bold small text-uppercase">Pilih Fasilitas:</label>
                <div class="row g-2">
                    @foreach($amenities as $amenity)
                        <div class="col-md-4 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" {{ in_array($amenity->id, $selectedAmenities) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="amenity_{{ $amenity->id }}">
                                    <i class="{{ $amenity->icon ?: 'bi-check2' }} text-success me-1"></i> {{ $amenity->name_id }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">4. Media Gambar & Foto</h5>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label">URL Foto Utama (Featured Image)</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $property->featured_image) }}">
            </div>
            <div class="col-12">
                <label class="form-label">URL Galeri Tambahan (1 baris per URL)</label>
                <textarea name="gallery_images_raw" rows="3" class="form-control">{{ old('gallery_images_raw', implode("\n", is_array($property->gallery_images) ? $property->gallery_images : [])) }}</textarea>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Perubahan Properti
            </button>
        </div>
    </form>
</div>
@endsection
