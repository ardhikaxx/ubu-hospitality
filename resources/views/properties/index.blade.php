@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Koleksi Properti & Stay</li>
            </ol>
        </nav>
        <h1 class="font-serif fw-bold text-dark mb-1">Cari Akomodasi & Villa Privat</h1>
        <p class="text-muted small mb-0">Temukan kenyamanan terbaik dari Ubu Villa, Buruj Villa (Syariah), dan koleksi glamping di Yogyakarta.</p>
    </div>
</div>

<div class="container py-4">
    <!-- Inline Filter Widget -->
    <div class="mb-4">
        <x-search-widget />
    </div>

    <!-- Mobile Filter Action Bar (< 992px) -->
    <div class="d-lg-none mb-3">
        <button class="btn btn-white border rounded-pill px-3 py-2.5 w-100 d-flex align-items-center justify-content-between shadow-sm bg-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#propertyFilterOffcanvas" aria-controls="propertyFilterOffcanvas">
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-ubu-primary fs-5"></i>
                <span class="fw-semibold text-dark">Filter & Urutkan Properti</span>
            </span>
            @php
                $activeFilters = 0;
                if(request('brand')) $activeFilters++;
                if(request('private_pool')) $activeFilters++;
                if(request('syariah')) $activeFilters++;
                if(request('city')) $activeFilters++;
                if(request('property_type')) $activeFilters++;
                if(request('bedrooms')) $activeFilters++;
            @endphp
            <span class="badge {{ $activeFilters > 0 ? 'bg-ubu-primary text-white' : 'bg-light text-muted border' }} rounded-pill px-2.5 py-1">
                {{ $activeFilters > 0 ? $activeFilters . ' Filter Aktif' : 'Atur Filter' }}
            </span>
        </button>
    </div>

    <!-- Mobile Filter Draw Menu (Offcanvas) -->
    <div class="offcanvas offcanvas-end mobile-draw-menu" tabindex="-1" id="propertyFilterOffcanvas" aria-labelledby="propertyFilterOffcanvasLabel">
        <div class="offcanvas-header drawer-header">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-ubu-primary" style="width: 34px; height: 34px;">
                    <i class="bi bi-funnel-fill"></i>
                </div>
                <h5 class="offcanvas-title fw-bold text-dark mb-0 fs-6" id="propertyFilterOffcanvasLabel">Filter & Urutkan Properti</h5>
            </div>
            <button type="button" class="btn-drawer-close" data-bs-dismiss="offcanvas" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="offcanvas-body drawer-body p-3">
            <form action="{{ route('stay.index') }}" method="GET">
                <!-- Preserve Dates and Guests -->
                <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                <input type="hidden" name="guests" value="{{ request('guests') }}">

                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <span class="text-muted small">Sesuaikan kriteria pencarian</span>
                    <a href="{{ route('stay.index') }}" class="small text-danger text-decoration-none fw-semibold">Reset Semua</a>
                </div>

                <!-- Brand Filter -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Brand</label>
                    @foreach($brands as $b)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="brand" value="{{ $b->slug }}" id="m_brand_{{ $b->id }}" {{ request('brand') == $b->slug ? 'checked' : '' }}>
                            <label class="form-check-label small" for="m_brand_{{ $b->id }}">
                                {{ $b->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Syariah & Private Pool Checkboxes -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Fasilitas Prioritas</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="private_pool" value="1" id="m_filterPool" {{ request('private_pool') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="m_filterPool">
                            <i class="bi bi-water text-primary me-1"></i> Private Pool
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="syariah" value="1" id="m_filterSyariahSide" {{ request('syariah') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="m_filterSyariahSide">
                            <i class="bi bi-shield-check text-warning me-1"></i> Syariah Compliant
                        </label>
                    </div>
                </div>

                <!-- Destination / City -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Lokasi / Area</label>
                    <select name="city" class="form-select form-select-sm">
                        <option value="">Semua Lokasi</option>
                        @foreach($destinations as $d)
                            <option value="{{ $d->name }}" {{ request('city') == $d->name ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Property Type -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Tipe Properti</label>
                    <select name="property_type" class="form-select form-select-sm">
                        <option value="">Semua Tipe</option>
                        @foreach($propertyTypes as $pt)
                            <option value="{{ $pt->slug }}" {{ request('property_type') == $pt->slug ? 'selected' : '' }}>
                                {{ $pt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Minimum Bedrooms -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Jumlah Kamar Tidur</label>
                    <select name="bedrooms" class="form-select form-select-sm">
                        <option value="">Bebas</option>
                        <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+ Kamar</option>
                        <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+ Kamar</option>
                        <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Kamar</option>
                        <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+ Kamar</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Urutkan</label>
                    <select name="sort" class="form-select form-select-sm">
                        <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Rekomendasi Terbaik</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="guests_high" {{ request('sort') == 'guests_high' ? 'selected' : '' }}>Kapasitas Tamu Terbesar</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-ubu-primary w-100 py-2.5 rounded-3 fw-semibold">
                    <i class="bi bi-funnel me-1"></i> Terapkan Filter
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Filter (Desktop >= 992px) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card border rounded-4 p-4 shadow-sm bg-white sticky-top" style="top: 85px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark fs-6"><i class="bi bi-funnel me-1 text-ubu-primary"></i> Filter Properti</h5>
                    <a href="{{ route('stay.index') }}" class="small text-danger text-decoration-none fw-semibold">Reset</a>
                </div>

                <form action="{{ route('stay.index') }}" method="GET">
                    <!-- Preserve Dates and Guests -->
                    <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                    <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                    <input type="hidden" name="guests" value="{{ request('guests') }}">

                    <!-- Brand Filter -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Brand</label>
                        @foreach($brands as $b)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="brand" value="{{ $b->slug }}" id="brand_{{ $b->id }}" {{ request('brand') == $b->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label small" for="brand_{{ $b->id }}">
                                    {{ $b->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Syariah & Private Pool Checkboxes -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Fasilitas Prioritas</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="private_pool" value="1" id="filterPool" {{ request('private_pool') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label small" for="filterPool">
                                <i class="bi bi-water text-primary me-1"></i> Private Pool
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="syariah" value="1" id="filterSyariahSide" {{ request('syariah') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label small" for="filterSyariahSide">
                                <i class="bi bi-shield-check text-warning me-1"></i> Syariah Compliant
                            </label>
                        </div>
                    </div>

                    <!-- Destination / City -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Lokasi / Area</label>
                        <select name="city" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Lokasi</option>
                            @foreach($destinations as $d)
                                <option value="{{ $d->name }}" {{ request('city') == $d->name ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Property Type -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Tipe Properti</label>
                        <select name="property_type" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Tipe</option>
                            @foreach($propertyTypes as $pt)
                                <option value="{{ $pt->slug }}" {{ request('property_type') == $pt->slug ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Minimum Bedrooms -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Jumlah Kamar Tidur</label>
                        <select name="bedrooms" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Bebas</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+ Kamar</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+ Kamar</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Kamar</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+ Kamar</option>
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Urutkan</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Rekomendasi Terbaik</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="guests_high" {{ request('sort') == 'guests_high' ? 'selected' : '' }}>Kapasitas Tamu Terbesar</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Property Listing Cards -->
        <div class="col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted small">
                    Ditemukan <strong>{{ $properties->total() }}</strong> properti sesuai pencarian Anda
                </span>

                <div class="d-none d-md-block">
                    <span class="small text-muted"><i class="bi bi-info-circle me-1"></i> Tarif final dan ketersediaan real-time diverifikasi via SENTEC</span>
                </div>
            </div>

            @if($properties->isEmpty())
                <x-empty-state
                    icon="bi-house-x"
                    title="Tidak Ada Villa Yang Cocok"
                    message="Kriteria pencarian yang Anda masukkan tidak menghasilkan properti yang tersedia. Coba ubah tanggal atau bersihkan filter."
                    actionText="Reset Pencarian"
                    :actionUrl="route('stay.index')"
                />
            @else
                <div class="row g-4">
                    @foreach($properties as $property)
                        <div class="col-md-6 col-xl-4">
                            <x-property-card :property="$property" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $properties->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
