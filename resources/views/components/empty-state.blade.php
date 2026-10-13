@props([
    'icon' => 'bi-search',
    'title' => 'Tidak Ada Data Ditemukan',
    'message' => 'Silakan sesuaikan filter pencarian Anda atau coba kata kunci lain.',
    'actionText' => 'Reset Filter',
    'actionUrl' => null
])

<div class="text-center py-5 px-3 bg-white rounded-4 border my-4">
    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-muted mb-3" style="width: 72px; height: 72px;">
        <i class="{{ $icon }} fs-1"></i>
    </div>
    <h4 class="font-serif fw-bold text-dark mb-2">{{ $title }}</h4>
    <p class="text-muted small max-w-md mx-auto mb-4" style="max-width: 460px;">{{ $message }}</p>
    @if($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" class="btn btn-sm btn-ubu-primary px-4">
            {{ $actionText }}
        </a>
    @endif
</div>
