@extends('layouts.admin')

@section('title', 'Optimasi SEO & Pengalihan URL')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Optimasi SEO & Pengalihan 301</h3>
        <p class="text-muted small mb-0">Kelola metadata bawaan pencarian Google serta aturan pengalihan URL (Redirects).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-diagram-3 me-1"></i> Buka Sitemap.xml
        </a>
        <a href="{{ url('/robots.txt') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-robot me-1"></i> Buka Robots.txt
        </a>
        <button type="button" class="btn btn-ubu-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRedirectModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Aturan Redirect
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Default Meta SEO -->
    <div class="col-lg-6">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">Metadata Default Mesin Pencari</h5>
            <form action="{{ route('admin.seo.settings') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small">Default Meta Title (Indonesia) <span class="text-danger">*</span></label>
                    <input type="text" name="default_meta_title_id" class="form-control" value="{{ old('default_meta_title_id', $settings['default_meta_title_id']) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Default Meta Title (Inggris) <span class="text-danger">*</span></label>
                    <input type="text" name="default_meta_title_en" class="form-control" value="{{ old('default_meta_title_en', $settings['default_meta_title_en']) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Default Meta Description (Indonesia) <span class="text-danger">*</span></label>
                    <textarea name="default_meta_description_id" rows="3" class="form-control" required>{{ old('default_meta_description_id', $settings['default_meta_description_id']) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Default Meta Description (Inggris) <span class="text-danger">*</span></label>
                    <textarea name="default_meta_description_en" rows="3" class="form-control" required>{{ old('default_meta_description_en', $settings['default_meta_description_en']) }}</textarea>
                </div>
                <button type="submit" class="btn btn-ubu-primary">
                    <i class="bi bi-save me-1"></i> Simpan Pengaturan SEO
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Schema Info -->
    <div class="col-lg-6">
        <div class="admin-card p-4 h-100">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">Schema.org JSON-LD & OpenGraph</h5>
            <div class="p-3 bg-light rounded small mb-3">
                <div class="fw-bold text-success mb-1"><i class="bi bi-check-circle-fill me-1"></i> Structured Data Aktif</div>
                <p class="text-muted mb-0">Platform Ubu Hospitality otomatis menyuntikkan schema <code>LodgingBusiness</code>, <code>Hotel</code>, dan <code>BreadcrumbList</code> secara dinamis ke seluruh halaman properti untuk mendukung Google Rich Snippets.</p>
            </div>
            <div class="p-3 bg-light rounded small mb-3">
                <div class="fw-bold text-primary mb-1"><i class="bi bi-share-fill me-1"></i> OpenGraph & Twitter Cards</div>
                <p class="text-muted mb-0">Setiap halaman dan artikel blog dilengkapi tag <code>og:title</code>, <code>og:image</code>, dan <code>og:description</code> untuk preview optimal saat dibagikan ke WhatsApp dan media sosial.</p>
            </div>
            <div class="p-3 bg-light rounded small">
                <div class="fw-bold text-dark mb-1"><i class="bi bi-arrow-repeat me-1"></i> Canonical URLs & 301 Protection</div>
                <p class="text-muted mb-0">Sistem secara otomatis menangani URL canonical untuk mencegah duplicate content penalty dari Google bot.</p>
            </div>
        </div>
    </div>
</div>

<!-- Redirects Management -->
<div class="admin-card p-0">
    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-dark mb-0 font-serif">Daftar Pengalihan URL (Redirects)</h5>
            <span class="text-muted small">Cegah error 404 dari URL lama atau promosi musiman</span>
        </div>
        <span class="badge bg-light text-dark border">{{ $redirects->total() }} Aturan</span>
    </div>

    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>URL Asal (Source)</th>
                    <th>URL Tujuan (Target)</th>
                    <th>Status Code</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th>Hits Count</th>
                    <th class="text-end pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($redirects as $red)
                    <tr>
                        <td><code class="text-dark">{{ $red->source_url }}</code></td>
                        <td><code class="text-primary">{{ $red->target_url }}</code></td>
                        <td>
                            <span class="badge {{ $red->status_code == 301 ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' }}">
                                {{ $red->status_code }} ({{ $red->status_code == 301 ? 'Permanent' : 'Temporary' }})
                            </span>
                        </td>
                        <td><span class="small text-muted">{{ $red->note ?? '-' }}</span></td>
                        <td>
                            @if($red->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td><span class="small font-monospace">{{ number_format($red->hits_count) }}</span></td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editRedirectModal{{ $red->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.seo.redirects.destroy', $red) }}" method="POST" onsubmit="return confirm('Hapus aturan redirect ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Modal Edit Redirect -->
                            <div class="modal fade text-start" id="editRedirectModal{{ $red->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-serif">Edit Aturan Redirect</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.seo.redirects.update', $red) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row g-3">
                                                <div class="col-12">
                                                    <label class="form-label small">URL Asal (Source) <span class="text-danger">*</span></label>
                                                    <input type="text" name="source_url" class="form-control font-monospace" value="{{ $red->source_url }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">URL Tujuan (Target) <span class="text-danger">*</span></label>
                                                    <input type="text" name="target_url" class="form-control font-monospace" value="{{ $red->target_url }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Status Code</label>
                                                    <select name="status_code" class="form-select">
                                                        <option value="301" {{ $red->status_code == 301 ? 'selected' : '' }}>301 - Permanent Redirect</option>
                                                        <option value="302" {{ $red->status_code == 302 ? 'selected' : '' }}>302 - Temporary Redirect</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Catatan</label>
                                                    <input type="text" name="note" class="form-control" value="{{ $red->note }}">
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="actRed{{ $red->id }}" {{ $red->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="actRed{{ $red->id }}">Aturan Aktif</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-ubu-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada aturan redirect yang dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($redirects->hasPages())
        <div class="p-3 border-top">
            {{ $redirects->links() }}
        </div>
    @endif
</div>

<!-- Modal Create Redirect -->
<div class="modal fade" id="createRedirectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-serif">Tambah Aturan Pengalihan (Redirect)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.seo.redirects.store') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label small">URL Asal (Source) <span class="text-danger">*</span></label>
                        <input type="text" name="source_url" class="form-control font-monospace" placeholder="/villa-lama-jogja" required>
                        <div class="form-text small">Mulai dengan tanda slash (misal: <code>/villa-lama</code>)</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small">URL Tujuan (Target) <span class="text-danger">*</span></label>
                        <input type="text" name="target_url" class="form-control font-monospace" placeholder="/stay/ubu-villa-gito-gati" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Status Code</label>
                        <select name="status_code" class="form-select">
                            <option value="301" selected>301 - Permanent Redirect</option>
                            <option value="302">302 - Temporary Redirect</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Catatan Alasan</label>
                        <input type="text" name="note" class="form-control" placeholder="Contoh: Migrasi URL lama">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="newRedActive" checked>
                            <label class="form-check-label small" for="newRedActive">Aktifkan Segera</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary">Simpan Aturan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
