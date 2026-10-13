@extends('layouts.public')

@section('content')
<!-- About Hero -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #16201b 0%, #1b3b2b 100%);">
    <div class="container py-4 text-center">
        <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-1 mb-3">Tentang Kami</span>
        <h1 class="font-serif display-4 fw-bold text-white mb-3">
            {{ $page->title }}
        </h1>
        <p class="fs-5 text-white-50 mx-auto mb-0" style="max-width: 680px;">
            {{ $page->subtitle }}
        </p>
    </div>
</section>

<div class="container py-5">
    <!-- Section: Company Story -->
    @php
        $storySection = $page->sections->where('section_key', 'company_story')->first();
    @endphp
    @if($storySection)
        <div class="row g-5 align-items-center mb-5 pb-4 border-bottom">
            <div class="col-lg-6">
                <span class="section-pill">{{ $storySection->subtitle }}</span>
                <h2 class="font-serif fw-bold text-dark mb-3">{{ $storySection->title }}</h2>
                <div class="text-secondary" style="line-height: 1.85;">
                    {!! nl2br(e($storySection->content)) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rounded-4 overflow-hidden shadow-lg" style="aspect-ratio: 16 / 11;">
                    <img src="{{ $storySection->media_path ?: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80' }}"
                         alt="Ubu Hospitality Story"
                         class="w-100 h-100 object-fit-cover">
                </div>
            </div>
        </div>
    @endif

    <!-- Section: Hospitality Standards -->
    @php
        $standardsSection = $page->sections->where('section_key', 'hospitality_standards')->first();
    @endphp
    @if($standardsSection)
        <div class="mb-5 pb-4 border-bottom">
            <div class="text-center mb-4">
                <span class="section-pill">{{ $standardsSection->subtitle }}</span>
                <h2 class="font-serif fw-bold text-dark">{{ $standardsSection->title }}</h2>
                <p class="text-muted small max-w-xl mx-auto" style="max-width: 600px;">{{ $standardsSection->content }}</p>
            </div>

            @if(!empty($standardsSection->extra_data))
                <div class="row g-4">
                    @foreach($standardsSection->extra_data as $pillar)
                        <div class="col-md-4">
                            <div class="card border rounded-4 p-4 h-100 shadow-sm bg-white text-center property-card">
                                <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                    <i class="{{ $pillar['icon'] ?? 'bi-shield-check' }} fs-2"></i>
                                </div>
                                <h5 class="font-serif fw-bold text-dark mb-2">{{ $pillar['title_id'] ?? '' }}</h5>
                                <p class="small text-muted mb-0">{{ $pillar['desc_id'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Brands Portfolio Overview -->
    <div class="mb-5">
        <div class="text-center mb-4">
            <span class="section-pill">Brand Portfolio</span>
            <h2 class="font-serif fw-bold text-dark">Brand Dalam Naungan Ubu Hospitality</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($brands as $brand)
                <div class="col-lg-4 col-md-6">
                    <x-brand-card :brand="$brand" />
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
