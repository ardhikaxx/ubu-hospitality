@props(['brand'])

<div class="brand-card">
    <div class="brand-card-accent-bar" style="background-color: {{ $brand->accent_color ?: '#0085a2' }};"></div>

    <div class="d-flex align-items-center justify-content-between mb-3 pt-2">
        <div>
            <h3 class="font-serif fw-bold text-dark mb-0">{{ $brand->name }}</h3>
            <span class="small fw-semibold" style="color: {{ $brand->accent_color ?: '#0085a2' }};">
                {{ $brand->tagline }}
            </span>
        </div>
        @if($brand->positioning_type === 'syariah')
            <span class="badge-syariah"><i class="bi bi-shield-check"></i> Syariah</span>
        @else
            <span class="badge-luxury"><i class="bi bi-gem"></i> Luxury</span>
        @endif
    </div>

    <p class="text-muted small mb-4 flex-grow-1">
        {{ $brand->description }}
    </p>

    @if(!empty($brand->character_highlights))
        <div class="mb-4">
            <h6 class="text-uppercase small fw-bold text-dark mb-2">Keunggulan Utama:</h6>
            <ul class="list-unstyled mb-0 small">
                @foreach(array_slice($brand->character_highlights, 0, 3) as $hl)
                    <li class="mb-1 text-muted d-flex align-items-start gap-2">
                        <i class="bi bi-check2-circle text-success mt-1"></i>
                        <span>{{ $hl }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
        <span class="small text-muted">
            <i class="bi bi-house-door me-1"></i> {{ $brand->properties_count ?? $brand->properties()->count() }} Properti Tersedia
        </span>
        <a href="{{ route('brand.show', $brand->slug) }}" class="btn btn-sm btn-ubu-outline">
            Jelajahi {{ $brand->name }} <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</div>
