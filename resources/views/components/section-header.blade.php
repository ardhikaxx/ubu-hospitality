@props([
    'pill' => null,
    'title',
    'desc' => null,
    'actionText' => null,
    'actionUrl' => null,
    'center' => false
])

<div class="section-header {{ $center ? 'text-center' : '' }}">
    <div class="d-flex flex-column flex-md-row {{ $center ? 'justify-content-center' : 'justify-content-between' }} align-items-{{ $center ? 'center' : 'md-end' }} gap-3">
        <div>
            @if($pill)
                <span class="section-pill">{{ $pill }}</span>
            @endif
            <h2 class="section-title">{{ $title }}</h2>
            @if($desc)
                <p class="section-desc mb-0 {{ $center ? 'mx-auto' : '' }}">{{ $desc }}</p>
            @endif
        </div>

        @if($actionText && $actionUrl)
            <div>
                <a href="{{ $actionUrl }}" class="btn btn-sm btn-ubu-outline">
                    {{ $actionText }} <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>
