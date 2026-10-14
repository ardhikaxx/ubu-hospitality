@props(['src' => null, 'alt' => '', 'fallback' => null])

@php
    $fallbackUrl = $fallback ?: default_image_url();
    $resolvedSrc = image_or_default($src, $fallbackUrl);
@endphp

<img src="{{ $resolvedSrc }}"
     alt="{{ $alt }}"
     onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';"
     {{ $attributes }} />
