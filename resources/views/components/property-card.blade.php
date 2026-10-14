@props(['property'])

@php
    $queryParams = request()->only(['check_in', 'check_out', 'guests', 'rooms']);
    $detailUrl = route('stay.show', array_merge(['slug' => $property->slug], $queryParams));
@endphp

<div class="property-card">
    <div class="property-card-img-wrapper">
        <x-fallback-image :src="$property->featured_image" alt="{{ $property->name }}" class="property-card-img" loading="lazy" />

        <div class="property-card-badges">
            @if($property->is_featured)
                <span class="badge-featured"><i class="bi bi-star-fill me-1"></i> Featured</span>
            @endif

            @if($property->is_syariah)
                <span class="badge-syariah"><i class="bi bi-shield-check"></i> Syariah Compliant</span>
            @endif

            @if($property->has_private_pool)
                <span class="badge-luxury"><i class="bi bi-water"></i> Private Pool</span>
            @endif
        </div>

        @if($property->brand)
            <div class="property-card-brand-badge">
                {{ $property->brand->name }}
            </div>
        @endif
    </div>

    <div class="property-card-body">
        <h3 class="property-card-title">
            <a href="{{ $detailUrl }}">{{ $property->name }}</a>
        </h3>

        <div class="property-card-location">
            <i class="bi bi-geo-alt-fill text-muted"></i>
            <span>{{ $property->city }}</span>
            @if($property->propertyType)
                <span class="text-muted ms-1">&bull; {{ $property->propertyType->name }}</span>
            @endif
        </div>

        <div class="property-card-specs">
            <span><i class="bi bi-people-fill"></i> Hingga {{ $property->max_guests }} Tamu</span>
            <span><i class="bi bi-door-closed-fill"></i> {{ $property->bedrooms }} Kamar</span>
            <span><i class="bi bi-droplet-half"></i> {{ $property->bathrooms }} KM</span>
        </div>

        @if($property->headline)
            <p class="small text-muted mb-3 text-truncate" title="{{ $property->headline }}">
                {{ $property->headline }}
            </p>
        @endif

        <div class="property-card-footer">
            <div>
                <div class="property-card-price-label">Mulai Dari</div>
                <div class="property-card-price-value">{{ $property->formatted_price }}</div>
                <div class="property-card-price-sub">/ malam (estimasi)</div>
            </div>

            <a href="{{ $detailUrl }}" class="btn btn-sm btn-ubu-primary px-3">
                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
