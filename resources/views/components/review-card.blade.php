@props(['review'])

<div class="review-card">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="star-rating">
            @for($i = 0; $i < $review->rating; $i++)
                <i class="bi bi-star-fill text-warning"></i>
            @endfor
        </div>
        <div class="badge bg-light text-muted border small d-flex align-items-center gap-1">
            <i class="bi bi-google text-primary"></i> <span>Google Review</span>
        </div>
    </div>

    <p class="text-dark fst-italic small mb-4 flex-grow-1">
        &ldquo;{{ $review->review_text }}&rdquo;
    </p>

    <div class="d-flex align-items-center gap-3 pt-3 border-top mt-auto">
        <div class="rounded-circle bg-success-subtle text-success fw-bold d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            {{ strtoupper(substr($review->guest_name, 0, 1)) }}
        </div>
        <div>
            <div class="fw-bold text-dark small">{{ $review->guest_name }}</div>
            <div class="text-muted" style="font-size: 0.75rem;">
                {{ $review->guest_origin ?: 'Tamu Terverifikasi' }}
                @if($review->property)
                    &bull; Menginap di {{ $review->property->name }}
                @endif
            </div>
        </div>
    </div>
</div>
