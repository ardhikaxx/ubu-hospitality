@extends('layouts.public')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stay.index') }}" class="text-decoration-none text-muted">Stay</a></li>
                @if($property->brand)
                    <li class="breadcrumb-item"><a href="{{ route('brand.show', $property->brand->slug) }}" class="text-decoration-none text-muted">{{ $property->brand->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $property->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <!-- Header Title & Badges -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-4">
        <div>
            <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                @if($property->brand)
                    <span class="badge bg-dark rounded-pill px-3 py-1">{{ $property->brand->name }}</span>
                @endif
                @if($property->is_syariah)
                    <span class="badge-syariah"><i class="bi bi-shield-check"></i> 100% Syariah Compliant</span>
                @endif
                @if($property->has_private_pool)
                    <span class="badge-luxury"><i class="bi bi-water"></i> Private Swimming Pool</span>
                @endif
            </div>

            <h1 class="font-serif fw-bold text-dark mb-1">{{ $property->name }}</h1>
            <p class="text-muted small mb-0">
                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $property->address }}, {{ $property->city }}
                @if($property->google_maps_url)
                    &bull; <a href="{{ $property->google_maps_url }}" target="_blank" class="text-success text-decoration-none fw-semibold">Lihat di Google Maps <i class="bi bi-box-arrow-up-right small"></i></a>
                @endif
            </p>
        </div>

        <div class="text-md-end">
            <div class="small text-muted">Mulai dari</div>
            <div class="fs-3 fw-bold text-success">{{ $property->formatted_price }}</div>
            <div class="small text-muted">/ malam (estimasi awal)</div>
        </div>
    </div>

    <!-- Photo Gallery Grid -->
    <div class="row g-2 mb-5">
        <div class="col-lg-8">
            <div class="rounded-4 overflow-hidden position-relative" style="height: 440px;">
                <x-fallback-image :src="$property->featured_image" alt="{{ $property->name }}" class="w-100 h-100 object-fit-cover" />
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block">
            <div class="row g-2 h-100">
                @php
                    $gallery = is_array($property->gallery_images) ? $property->gallery_images : [];
                    $subImages = array_slice($gallery, 0, 2);
                @endphp
                @foreach($subImages as $img)
                    <div class="col-12" style="height: 216px;">
                        <div class="rounded-4 overflow-hidden h-100">
                            <x-fallback-image :src="$img" alt="{{ $property->name }}" class="w-100 h-100 object-fit-cover" />
                        </div>
                    </div>
                @endforeach
                @if(count($subImages) < 2)
                    <div class="col-12" style="height: 216px;">
                        <div class="rounded-4 overflow-hidden h-100 bg-secondary-subtle d-flex align-items-center justify-content-center text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content (Left) -->
        <div class="col-lg-8">
            <!-- Property Key Highlights -->
            <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                <div class="row text-center g-3">
                    <div class="col-3 border-end">
                        <i class="bi bi-people fs-3 text-success"></i>
                        <div class="fw-bold text-dark mt-1">{{ $property->max_guests }} Tamu</div>
                        <div class="small text-muted">Kapasitas Maksimal</div>
                    </div>
                    <div class="col-3 border-end">
                        <i class="bi bi-door-closed fs-3 text-success"></i>
                        <div class="fw-bold text-dark mt-1">{{ $property->bedrooms }} Kamar</div>
                        <div class="small text-muted">{{ $property->beds_description ?: 'Kamar Tidur Nyaman' }}</div>
                    </div>
                    <div class="col-3 border-end">
                        <i class="bi bi-droplet-half fs-3 text-success"></i>
                        <div class="fw-bold text-dark mt-1">{{ $property->bathrooms }} KM</div>
                        <div class="small text-muted">Water Heater</div>
                    </div>
                    <div class="col-3">
                        <i class="bi bi-aspect-ratio fs-3 text-success"></i>
                        <div class="fw-bold text-dark mt-1">{{ $property->area_sqm ?: '250' }} m²</div>
                        <div class="small text-muted">Luas Bangunan</div>
                    </div>
                </div>
            </div>

            <!-- Syariah Highlights Callout (If applicable) -->
            @if($property->is_syariah)
                <div class="card border-0 rounded-4 p-4 mb-4" style="background-color: #0f2c3d; color: #ffffff;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning p-3 text-dark fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h4 class="font-serif fw-bold text-warning mb-1">Jaminan Kenyamanan Syariah Buruj</h4>
                            <p class="small text-white-50 mb-3">
                                Properti ini dikelola dengan standar syariah yang ketat untuk memastikan ketenangan hati keluarga muslim selama berlibur:
                            </p>
                            <div class="row g-2 small">
                                <div class="col-md-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    <span>Kolam renang tertutup dari celah pandang luar</span>
                                </div>
                                <div class="col-md-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    <span>Perlengkapan sholat bersih & arah kiblat akurat</span>
                                </div>
                                <div class="col-md-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    <span>Lingkungan 100% bebas minuman beralkohol</span>
                                </div>
                                <div class="col-md-6 d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                    <span>Khusus pasangan halal & keluarga muslim</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                <h4 class="font-serif fw-bold text-dark mb-3">Tentang Properti</h4>
                <div class="text-secondary" style="line-height: 1.8;">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>

            <!-- Amenities -->
            <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                <h4 class="font-serif fw-bold text-dark mb-3">Fasilitas Lengkap</h4>
                <div class="row g-3">
                    @foreach($property->amenities as $amenity)
                        <div class="col-md-6 col-lg-4">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light border">
                                <i class="{{ $amenity->icon ?: 'bi-check2-circle' }} fs-5 text-success"></i>
                                <span class="small fw-semibold text-dark">{{ $amenity->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Unit / Room Types (if available) -->
            @if($property->units->isNotEmpty())
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                    <h4 class="font-serif fw-bold text-dark mb-3">Pilihan Tipe Kamar / Unit</h4>
                    <div class="row g-3">
                        @foreach($property->units as $unit)
                            <div class="col-12">
                                <div class="border rounded-3 p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">{{ $unit->name }}</h5>
                                        <p class="small text-muted mb-1">{{ $unit->description }}</p>
                                        <div class="small text-muted d-flex gap-3">
                                            <span><i class="bi bi-people"></i> {{ $unit->capacity_guests }} Tamu</span>
                                            <span><i class="bi bi-door-closed"></i> {{ $unit->bedrooms }} Kamar</span>
                                            <span><i class="bi bi-bounding-box"></i> {{ $unit->area_sqm }} m²</span>
                                        </div>
                                    </div>
                                    <div class="text-md-end">
                                        <div class="fw-bold text-success fs-5">Rp {{ number_format((float) $unit->price_estimate, 0, ',', '.') }}</div>
                                        <div class="small text-muted">/ malam</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- House Rules & Policies -->
            <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                <h4 class="font-serif fw-bold text-dark mb-3">Kebijakan & Aturan Menginap</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark small text-uppercase mb-2"><i class="bi bi-clock me-1"></i> Waktu Check-In & Check-Out</h6>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li>Check-in: <strong>Mulai {{ $property->checkin_time }} WIB</strong></li>
                            <li>Check-out: <strong>Maksimal {{ $property->checkout_time }} WIB</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark small text-uppercase mb-2"><i class="bi bi-arrow-counterclockwise me-1"></i> Kebijakan Pembatalan</h6>
                        <p class="small text-muted mb-0">
                            {{ $property->cancellation_policy ?: 'Pembatalan gratis hingga 7 hari sebelum kedatangan.' }}
                        </p>
                    </div>
                    @if($property->house_rules)
                        <div class="col-12 pt-2 border-top">
                            <h6 class="fw-bold text-dark small text-uppercase mb-2"><i class="bi bi-card-checklist me-1"></i> Tata Tertib Properti</h6>
                            <div class="small text-muted">
                                {!! nl2br(e($property->house_rules)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Nearby Attractions -->
            @if(!empty($property->nearby_attractions))
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                    <h4 class="font-serif fw-bold text-dark mb-3">Tempat Menarik di Sekitar</h4>
                    <div class="row g-2">
                        @foreach($property->nearby_attractions as $attraction)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 small text-dark p-2 rounded-2 bg-light">
                                    <i class="bi bi-compass text-danger"></i>
                                    <strong>{{ $attraction['title'] ?? '' }}</strong>
                                    <span class="text-muted ms-auto">{{ $attraction['distance'] ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Official Video Tour (YouTube Embed from ubuvilla.com) -->
            @if(!empty($property->video_url))
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <span class="badge bg-danger text-white mb-1"><i class="bi bi-youtube me-1"></i> Video Tur Resmi</span>
                            <h4 class="font-serif fw-bold text-dark mb-0">Video Suasana Nyata {{ $property->name }}</h4>
                        </div>
                        @if(!empty($property->virtual_tour_url))
                            <a href="{{ $property->virtual_tour_url }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-badge-3d me-1"></i> Tur 360° Virtual
                            </a>
                        @endif
                    </div>
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden shadow-sm">
                        <iframe src="{{ $property->video_url }}" title="Tur Video Resmi {{ $property->name }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            @endif

            <!-- Interactive Google Maps Embed (From ubuvilla.com) -->
            @if(!empty($property->google_maps_embed_url))
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Lokasi & Navigasi</span>
                            <h4 class="font-serif fw-bold text-dark mb-0">Peta Lokasi Interaktif</h4>
                        </div>
                        @if($property->google_maps_url)
                            <a href="{{ $property->google_maps_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                Rute di Google Maps <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden border">
                        <iframe src="{{ $property->google_maps_embed_url }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p class="small text-muted mt-2 mb-0">
                        <i class="bi bi-info-circle me-1"></i> {{ $property->address }}, {{ $property->city }}
                    </p>
                </div>
            @endif

            <!-- Guest Reviews for this Property -->
            @if($reviews->isNotEmpty())
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="font-serif fw-bold text-dark mb-0">Ulasan Tamu Google Maps</h4>
                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> 5.0 Rating Sempurna</span>
                    </div>
                    <div class="row g-3">
                        @foreach($reviews as $rev)
                            <div class="col-12">
                                <x-review-card :review="$rev" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky Reservation Booking Box (Right) -->
        <div class="col-lg-4">
            <div class="position-sticky" style="top: 90px;">
                <div class="card border rounded-4 p-4 shadow-lg bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <span class="small text-muted">Tarif Mulai Dari</span>
                            <div class="fs-4 fw-bold text-success">{{ $property->formatted_price }}</div>
                            <span class="text-muted" style="font-size: 0.75rem;">/ malam (estimasi)</span>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
                            <i class="bi bi-shield-check"></i> Booking Resmi
                        </span>
                    </div>

                    <!-- Date Selection Form -->
                    <form action="{{ route('stay.show', $property->slug) }}" method="GET" id="detailBookingForm">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted mb-1">Check-in</label>
                                <input type="text" name="check_in" id="detailCheckIn" class="form-control form-control-sm" value="{{ $checkIn }}" readonly required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted mb-1">Check-out</label>
                                <input type="text" name="check_out" id="detailCheckOut" class="form-control form-control-sm" value="{{ $checkOut }}" readonly required>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted mb-1">Jumlah Tamu</label>
                                <select name="guests" class="form-select form-select-sm">
                                    @for($i = 1; $i <= $property->max_guests; $i++)
                                        <option value="{{ $i }}" {{ $guests == $i ? 'selected' : '' }}>{{ $i }} Tamu</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted mb-1">Kode Promo</label>
                                <input type="text" name="promo_code" class="form-control form-control-sm text-uppercase" placeholder="Contoh: UBUWELCOME" value="{{ request('promo_code') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mb-3">
                            <i class="bi bi-arrow-repeat"></i> Perbarui Tanggal
                        </button>
                    </form>

                    <!-- Real-Time SENTEC Availability Status Box -->
                    <div class="p-3 rounded-3 mb-3 {{ ($availability['available'] ?? false) ? 'bg-success-subtle border border-success text-success-emphasis' : 'bg-light border text-secondary' }}">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi {{ ($availability['available'] ?? false) ? 'bi-check-circle-fill text-success fs-5' : 'bi-info-circle text-primary fs-5' }}"></i>
                            <strong class="small">Ketersediaan SENTEC</strong>
                        </div>
                        <p class="small mb-1">
                            {{ $availability['message'] ?? 'Hubungkan tanggal untuk memverifikasi ketersediaan kamar secara real-time.' }}
                        </p>
                        @if($availability['is_mock'] ?? false)
                            <div class="badge bg-warning text-dark small" style="font-size: 0.7rem;">
                                <i class="bi bi-gear-wide-connected"></i> Mode Integrasi Mock SENTEC
                            </div>
                        @endif
                    </div>

                    <!-- Book CTA Leading to SENTEC Booking Engine -->
                    <a href="{{ $bookingUrl }}" target="_blank" class="btn btn-ubu-primary w-100 py-3 fw-bold fs-6 shadow mb-2">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Pesan Sekarang via SENTEC
                    </a>

                    <div class="text-center small text-muted mb-3" style="font-size: 0.75rem;">
                        <i class="bi bi-lock-fill"></i> Reservasi aman dialihkan ke engine resmi SENTEC
                    </div>

                    <!-- Direct WhatsApp CS Assistance -->
                    <a href="https://wa.me/6281234567890?text=Halo%20Ubu%20Hospitality%2C%20saya%20ingin%20bertanya%20mengenai%20ketersediaan%20{{ urlencode($property->name) }}%20untuk%20tanggal%20{{ $checkIn }}%20sampai%20{{ $checkOut }}"
                       target="_blank"
                       class="btn btn-outline-success w-100 py-2 small d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp"></i> Tanya CS via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Properties -->
    @if($relatedProperties->isNotEmpty())
        <div class="mt-5 pt-4 border-top">
            <h3 class="font-serif fw-bold text-dark mb-4">Properti Terkait Lainnya</h3>
            <div class="row g-4">
                @foreach($relatedProperties as $rel)
                    <div class="col-md-4">
                        <x-property-card :property="$rel" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof flatpickr !== 'undefined') {
            const IndonesianLocale = {
                weekdays: {
                    shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                    longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
                },
                months: {
                    shorthand: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                    longhand: [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember",
                    ],
                },
                firstDayOfWeek: 1,
            };

            let detailCheckOutPicker;
            const detailCheckInPicker = flatpickr("#detailCheckIn", {
                locale: IndonesianLocale,
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j M Y",
                minDate: "today",
                defaultDate: "{{ $checkIn }}",
                disableMobile: true,
                onChange: function (selectedDates) {
                    if (selectedDates.length > 0 && detailCheckOutPicker) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        detailCheckOutPicker.set('minDate', nextDay);
                        if (!detailCheckOutPicker.selectedDates.length || detailCheckOutPicker.selectedDates[0] <= selectedDates[0]) {
                            detailCheckOutPicker.setDate(nextDay, true);
                        }
                    }
                }
            });

            detailCheckOutPicker = flatpickr("#detailCheckOut", {
                locale: IndonesianLocale,
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j M Y",
                minDate: "{{ date('Y-m-d', strtotime($checkIn . ' +1 day')) }}",
                defaultDate: "{{ $checkOut }}",
                disableMobile: true,
            });
        }
    });
</script>
@endpush
