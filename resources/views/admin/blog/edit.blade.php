@extends('layouts.admin')

@section('title', 'Edit Artikel: ' . $post->title_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Artikel</h3>
        <p class="text-muted small mb-0">Perbarui konten artikel, foto cover, kategori, atau status publikasi.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline-info btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview di Web
        </a>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="admin-card p-4">
    <form action="{{ route('admin.blog.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label">Judul Artikel (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control @error('title_id') is-invalid @enderror" value="{{ old('title_id', $post->title_id) }}" required>
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name_id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <label class="form-label">Judul Artikel (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $post->title_en) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug URL <span class="text-danger">*</span></label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">URL Foto Cover / Featured Image</label>
                <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $post->featured_image) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Ringkasan / Excerpt (Indonesia)</label>
                <textarea name="excerpt_id" rows="3" class="form-control">{{ old('excerpt_id', $post->excerpt_id) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ringkasan / Excerpt (Inggris)</label>
                <textarea name="excerpt_en" rows="3" class="form-control">{{ old('excerpt_en', $post->excerpt_en) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Konten Lengkap Artikel (Indonesia) <span class="text-danger">*</span></label>
                <textarea name="content_id" rows="12" class="form-control font-monospace @error('content_id') is-invalid @enderror" required>{{ old('content_id', $post->content_id) }}</textarea>
                @error('content_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Konten Lengkap Artikel (Inggris)</label>
                <textarea name="content_en" rows="8" class="form-control font-monospace">{{ old('content_en', $post->content_en) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Estimasi Waktu Baca (Menit)</label>
                <input type="number" name="reading_time_minutes" class="form-control" value="{{ old('reading_time_minutes', $post->reading_time_minutes) }}" min="1">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published (Terbitkan)</option>
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Scheduled (Terjadwal)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>

        <div class="text-end border-top pt-3">
            <button type="submit" class="btn btn-ubu-primary px-4">
                <i class="bi bi-save me-1"></i> Perbarui Artikel
            </button>
        </div>
    </form>
</div>
@endsection
