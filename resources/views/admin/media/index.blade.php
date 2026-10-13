@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Pustaka Media & Aset</h3>
        <p class="text-muted small mb-0">Kelola foto properti, banner promosi, logo, dan dokumen visual platform.</p>
    </div>
    <button type="button" class="btn btn-ubu-primary" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
        <i class="bi bi-cloud-arrow-up me-1"></i> Unggah Media Baru
    </button>
</div>

<!-- Media Grid -->
<div class="row g-4">
    @forelse($mediaFiles as $media)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="admin-card p-2 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="ratio ratio-1x1 bg-light rounded overflow-hidden mb-2 border position-relative group-action">
                        @if(str_starts-with($media->mime_type, 'image/'))
                            <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="object-fit-cover w-100 h-100">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="bi bi-file-earmark-text display-4"></i>
                            </div>
                        @endif
                    </div>
                    <div class="small fw-semibold text-truncate text-dark" title="{{ $media->original_name }}">
                        {{ $media->original_name }}
                    </div>
                    <div class="text-muted small" style="font-size: 0.75rem;">
                        {{ number_format($media->file_size / 1024, 1) }} KB &bull; {{ $media->created_at->format('d/m/y') }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top">
                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" onclick="copyToClipboard('{{ $media->url }}')" title="Salin URL">
                        <i class="bi bi-link-45deg"></i> URL
                    </button>
                    <form action="{{ route('admin.media.destroy', $media) }}" method="POST" onsubmit="return confirm('Hapus file ini permanen?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.75rem;" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="admin-card p-5 text-center text-muted">
                <i class="bi bi-images display-4 d-block mb-3"></i>
                <h5 class="fw-bold">Belum Ada Media yang Diunggah</h5>
                <p class="small text-muted mb-3">Unggah foto resolusi tinggi untuk villa, pengalaman, atau banner promosi Anda.</p>
                <button type="button" class="btn btn-ubu-primary" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Unggah Sekarang
                </button>
            </div>
        </div>
    @endforelse
</div>

@if($mediaFiles->hasPages())
    <div class="mt-4">
        {{ $mediaFiles->links() }}
    </div>
@endif

<!-- Modal Upload -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-serif">Unggah File Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label">Pilih File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" required accept="image/*">
                        <div class="form-text small">Maksimal 5MB. Format: JPG, PNG, WEBP, SVG, GIF.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alt Text (Aksesibilitas & SEO)</label>
                        <input type="text" name="alt_text_id" class="form-control" placeholder="Contoh: Kolam Renang Private Ubu Villa Gito Gati">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Caption / Catatan Singkat</label>
                        <input type="text" name="caption" class="form-control" placeholder="Keterangan opsional mengenai foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary">Unggah ke Server</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'URL Disalin!',
                text: text,
                timer: 1800,
                showConfirmButton: false
            });
        } else {
            alert('URL disalin ke clipboard:\n' + text);
        }
    });
}
</script>
@endsection
