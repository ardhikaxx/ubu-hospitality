@extends('layouts.admin')

@section('title', 'Buat Artikel Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Buat Artikel Baru</h3>
        <p class="text-muted small mb-0">Publikasikan panduan perjalanan, rekomendasi villa, kuliner lokal, atau tips liburan.</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label">Judul Artikel (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id') }}" required placeholder="Contoh: 5 Rekomendasi Villa Private Pool Terbaik di Jogja untuk Liburan Keluarga">
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name_id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <label class="form-label">Judul Artikel (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required placeholder="5 Best Private Pool Villas in Yogyakarta for Family Vacation">
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug URL (Opsional)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Otomatis dari judul jika dikosongkan">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Upload Foto Cover / Featured Image</label>
                <input type="file" name="featured_image_file" class="form-control" accept="image/*">
                <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 5MB. Disimpan otomatis tanpa storage:link.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Atau URL Foto Cover (Alternatif)</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image') }}" placeholder="https://...">
            </div>

            <div class="col-md-6">
                <label class="form-label">Ringkasan / Excerpt (Indonesia)</label>
                <textarea name="excerpt_id" rows="3" class="form-control" placeholder="Tuliskan 1-2 kalimat ringkasan yang menarik...">{{ old('excerpt_id') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ringkasan / Excerpt (Inggris)</label>
                <textarea name="excerpt_en" rows="3" class="form-control" placeholder="English short summary...">{{ old('excerpt_en') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Konten Lengkap Artikel (Indonesia) <span class="text-danger">*</span></label>
                <textarea name="content_id" rows="12" class="form-control font-monospace @error('content_id') is-invalid @enderror" required placeholder="Tulis isi artikel lengkap disini (format HTML atau paragraf teks didukung)...">{{ old('content_id') }}</textarea>
                @error('content_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Konten Lengkap Artikel (Inggris)</label>
                <textarea name="content_en" rows="8" class="form-control font-monospace" placeholder="English content...">{{ old('content_en') }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Estimasi Waktu Baca (Menit)</label>
                <input type="number" name="reading_time_minutes" class="form-control" value="{{ old('reading_time_minutes', 4) }}" min="1">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="published" selected>Published (Terbitkan Sekarang)</option>
                    <option value="draft">Draft (Simpan Konsep)</option>
                    <option value="scheduled">Scheduled (Terjadwal)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', date('Y-m-d\TH:i')) }}">
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Terbitkan Artikel
            </button>
        </div>
    </form>
</div>
@endsection
