@props(['promotion'])

<div class="promo-card">
    <div class="promo-card-banner">
        <x-fallback-image :src="$promotion->banner_image" alt="{{ $promotion->title }}" loading="lazy" />
        <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-danger fw-bold px-2 py-1">
                {{ $promotion->discount_label }}
            </span>
        </div>
    </div>

    <div class="p-3 d-flex flex-column flex-grow-1">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="promo-code-badge">
                <i class="bi bi-scissors"></i> {{ $promotion->code }}
            </span>
            @if($promotion->is_new_user_only)
                <span class="badge bg-info text-dark small">Tamu Baru</span>
            @endif
        </div>

        <h4 class="font-serif fs-5 fw-bold text-dark mb-1">{{ $promotion->title }}</h4>
        <p class="small text-muted mb-3 flex-grow-1">{{ $promotion->subtitle ?: $promotion->description }}</p>

        <div class="small text-muted pt-2 border-top mb-3">
            <div><i class="bi bi-calendar3 me-1"></i> Periode Booking: <strong>s/d {{ $promotion->booking_period_end->format('d M Y') }}</strong></div>
            <div><i class="bi bi-clock me-1"></i> Periode Menginap: <strong>{{ $promotion->stay_period_start->format('d M') }} - {{ $promotion->stay_period_end->format('d M Y') }}</strong></div>
        </div>

        <div class="d-flex gap-2 mt-auto">
            <a href="{{ route('offer.show', $promotion->slug) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                S&K Promo
            </a>
            <a href="{{ route('stay.index', ['promo_code' => $promotion->code]) }}" class="btn btn-sm btn-ubu-primary flex-grow-1">
                Gunakan Kode <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
