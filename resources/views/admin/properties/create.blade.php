@extends('layouts.admin')

@section('title', 'Tambah Properti Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Tambah Properti Baru</h3>
        <p class="text-muted small mb-0">Isi detail editorial, kapasitas, integrasi SENTEC ID, dan fasilitas properti.</p>
    </div>
    <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">1. Informasi Pokok & Brand</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Nama Properti <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Ubu Villa Gito Gati">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Brand <span class="text-danger">*</span></label>
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                    <option value="">Pilih Brand</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipe Properti <span class="text-danger">*</span></label>
                <select name="property_type_id" class="form-select @error('property_type_id') is-invalid @enderror" required>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->id }}" {{ old('property_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                    @endforeach
                </select>
                @error('property_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Headline / Ringkasan Daya Tarik</label>
                <input type="text" name="headline_id" class="form-control" value="{{ old('headline_id') }}" placeholder="Private pool villa elegan di Sleman dengan suasana tropis">
            </div>
            <div class="col-md-3">
                <label class="form-label">Kota / Area <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" value="{{ old('city', 'Sleman, Yogyakarta') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Destinasi Utama</label>
                <select name="destination_id" class="form-select">
                    <option value="">Pilih Area</option>
                    @foreach($destinations as $d)
                        <option value="{{ $d->id }}" {{ old('destination_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Alamat Lengkap</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Jl. Gito Gati No. 45, Sariharjo, Ngaglik, Sleman">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea name="description_id" rows="4" class="form-control @error('description_id') is-invalid @enderror" required>{{ old('description_id') }}</textarea>
                @error('description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">2. Integrasi SENTEC & Spesifikasi Kapasitas</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">SENTEC Property ID</label>
                <input type="text" name="sentec_property_id" class="form-control font-monospace @error('sentec_property_id') is-invalid @enderror" value="{{ old('sentec_property_id') }}" placeholder="Contoh: SENTEC-UV-001">
                <small class="text-muted" style="font-size: 0.75rem;">Kode penghubung ketersediaan dan tarif real-time SENTEC.</small>
                @error('sentec_property_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Tarif Mulai Dari (Estimasi Tampilan) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="starting_price_display" class="form-control @error('starting_price_display') is-invalid @enderror" value="{{ old('starting_price_display', 1500000) }}" required>
                </div>
                @error('starting_price_display') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="published" selected>Published (Terbit di Web)</option>
                    <option value="draft">Draft (Draf Internal)</option>
                    <option value="archived">Archived (Diarsipkan)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kapasitas Maksimal Tamu <span class="text-danger">*</span></label>
                <input type="number" name="max_guests" class="form-control" value="{{ old('max_guests', 6) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah Kamar Tidur <span class="text-danger">*</span></label>
                <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms', 3) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah Kamar Mandi <span class="text-danger">*</span></label>
                <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms', 3) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label">Luas Bangunan (m²)</label>
                <input type="number" name="area_sqm" class="form-control" value="{{ old('area_sqm', 250) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi Kasur</label>
                <input type="text" name="beds_description" class="form-control" value="{{ old('beds_description', '2 King Beds, 1 Queen Bed') }}">
            </div>
        </div>

        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">3. Fasilitas & Fitur Khusus</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="has_private_pool" value="1" id="hasPool" checked>
                    <label class="form-check-label fw-bold small" for="hasPool">Memiliki Private Swimming Pool</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_syariah" value="1" id="isSyariah">
                    <label class="form-check-label fw-bold small" for="isSyariah">Standar Syariah Compliant (Buruj)</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" checked>
                    <label class="form-check-label fw-bold small" for="isFeatured">Tampilkan di Pilihan Unggulan (Featured)</label>
                </div>
            </div>

            <div class="col-12 mt-3">
                <label class="form-label fw-bold small text-uppercase">Pilih Fasilitas Tambahan:</label>
                <div class="row g-2">
                    @foreach($amenities as $amenity)
                        <div class="col-md-4 col-lg-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}" checked>
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
            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Foto Utama (Featured Image)</label>
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 5MB. Otomatis dikompres & disimpan tanpa storage:link.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Foto Utama (Alternatif)</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image') }}" placeholder="https://...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Foto Galeri (Bisa Pilih Banyak File Sekaligus)</label>
                <input type="file" name="gallery_files[]" class="form-control" multiple accept="image/*">
                <small class="text-muted d-block mt-1">Pilih beberapa foto sekaligus untuk menambah galeri properti.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Galeri Tambahan (1 baris per URL)</label>
                <textarea name="gallery_images_raw" rows="3" class="form-control" placeholder="https://...&#10;https://...">{{ old('gallery_images_raw') }}</textarea>
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Simpan Properti Baru
            </button>
        </div>
    </form>
</div>
@endsection
