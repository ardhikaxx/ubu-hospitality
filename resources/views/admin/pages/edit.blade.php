@extends('layouts.admin')

@section('title', 'Edit Halaman: ' . $page->title_id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Edit Halaman: {{ $page->title_id }}</h3>
        <p class="text-muted small mb-0">Kelola informasi meta halaman dan isi setiap seksi konten modular.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-outline-info btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview di Web
        </a>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Kembali
        </a>
    </div>
</div>

<!-- Main Page Info & SEO -->
<div class="admin-card p-4 mb-4">
    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Informasi Halaman & Meta SEO</h5>
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Judul Halaman (Indonesia) <span class="text-danger">*</span></label>
                <input type="text" name="title_id" class="form-control" value="{{ old('title_id', $page->title_id) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Judul Halaman (Inggris) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $page->title_en) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Subjudul Halaman (Indonesia)</label>
                <input type="text" name="subtitle_id" class="form-control" value="{{ old('subtitle_id', $page->subtitle_id) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subjudul Halaman (Inggris)</label>
                <input type="text" name="subtitle_en" class="form-control" value="{{ old('subtitle_en', $page->subtitle_en) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Meta Title SEO</label>
                <input type="text" name="meta_title_id" class="form-control" value="{{ old('meta_title_id', $page->meta_title_id) }}" placeholder="Judul pada tab browser & search engine">
            </div>

            <div class="col-12">
                <label class="form-label">Meta Description SEO</label>
                <textarea name="meta_description_id" rows="2" class="form-control" placeholder="Deskripsi ringkas 150-160 karakter untuk Google search snippet">{{ old('meta_description_id', $page->meta_description_id) }}</textarea>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-ubu-primary btn-sm px-3">
                    <i class="bi bi-save me-1"></i> Simpan Info Halaman
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Page Modular Sections -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark font-serif mb-0">Seksi Konten Modular ({{ $page->sections->count() }})</h5>
</div>

@forelse($page->sections as $section)
    <div class="admin-card p-4 mb-3 border-start border-4 border-success">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="badge bg-secondary font-monospace me-2">{{ $section->section_key }}</span>
                <span class="fw-bold text-dark">{{ $section->title_id ?? 'Tanpa Judul' }}</span>
            </div>
            <div>
                @if($section->is_active)
                    <span class="badge bg-success-subtle text-success">Aktif</span>
                @else
                    <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                @endif
            </div>
        </div>

        <form action="{{ route('admin.pages.section.update', $section) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Judul Seksi (Indonesia)</label>
                    <input type="text" name="title_id" class="form-control form-control-sm" value="{{ old('title_id', $section->title_id) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Judul Seksi (Inggris)</label>
                    <input type="text" name="title_en" class="form-control form-control-sm" value="{{ old('title_en', $section->title_en) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Subjudul Seksi (Indonesia)</label>
                    <input type="text" name="subtitle_id" class="form-control form-control-sm" value="{{ old('subtitle_id', $section->subtitle_id) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Subjudul Seksi (Inggris)</label>
                    <input type="text" name="subtitle_en" class="form-control form-control-sm" value="{{ old('subtitle_en', $section->subtitle_en) }}">
                </div>

                <div class="col-12">
                    <label class="form-label small">URL Foto / Media Pendukung</label>
                    <input type="text" name="media_path" class="form-control form-control-sm" value="{{ old('media_path', $section->media_path) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label small">Isi Konten Seksi (Indonesia)</label>
                    <textarea name="content_id" rows="4" class="form-control form-control-sm font-monospace">{{ old('content_id', $section->content_id) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Isi Konten Seksi (Inggris)</label>
                    <textarea name="content_en" rows="4" class="form-control form-control-sm font-monospace">{{ old('content_en', $section->content_en) }}</textarea>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeSec{{ $section->id }}" {{ $section->is_active ? 'checked' : '' }}>
                        <label class="form-check-label small" for="activeSec{{ $section->id }}">Tampilkan seksi ini pada halaman publik</label>
                    </div>
                </div>

                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-save me-1"></i> Perbarui Seksi Ini
                    </button>
                </div>
            </div>
        </form>
    </div>
@empty
    <div class="admin-card p-4 text-center text-muted">
        Halaman ini belum memiliki seksi modular.
    </div>
@endforelse

@endsection
