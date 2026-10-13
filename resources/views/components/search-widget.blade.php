@props(['compact' => false])

@php
    $destinations = \App\Models\Destination::active()->orderBy('sort_order')->get();
    $brands = \App\Models\Brand::active()->ordered()->get();
    $propertyTypes = \App\Models\PropertyType::active()->orderBy('sort_order')->get();

    $defaultCheckIn = request('check_in', \Carbon\Carbon::tomorrow()->toDateString());
    $defaultCheckOut = request('check_out', \Carbon\Carbon::tomorrow()->addDay()->toDateString());
    $defaultGuests = request('guests', 2);
    $selectedBrand = request('brand', '');
    $selectedDestination = request('city', '');
@endphp

<div class="booking-search-widget">
    <form action="{{ route('stay.index') }}" method="GET" id="searchWidgetForm">
        <!-- Quick Filter Pills -->
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button type="button" class="btn btn-sm {{ empty(request('syariah')) && empty(request('private_pool')) ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 search-filter-pill" data-filter="all">
                Semua Properti
            </button>
            <button type="button" class="btn btn-sm {{ request('private_pool') ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 search-filter-pill" data-filter="pool">
                <i class="bi bi-water text-primary me-1"></i> Private Pool
            </button>
            <button type="button" class="btn btn-sm {{ request('syariah') ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 search-filter-pill" data-filter="syariah">
                <i class="bi bi-shield-check text-warning me-1"></i> Syariah Stay
            </button>
            <input type="hidden" name="private_pool" id="filterPrivatePool" value="{{ request('private_pool') }}">
            <input type="hidden" name="syariah" id="filterSyariah" value="{{ request('syariah') }}">
        </div>

        <div class="row g-2 align-items-center">
            <!-- 1. Destination / Brand -->
            <div class="col-lg-3 col-md-6">
                <div class="search-input-field">
                    <label class="search-input-label">
                        <i class="bi bi-geo-alt-fill text-muted"></i> Destinasi / Area
                    </label>
                    <select name="city" class="search-input-control">
                        <option value="">Semua Area di Yogyakarta</option>
                        @foreach($destinations as $d)
                            <option value="{{ $d->name }}" {{ $selectedDestination == $d->name ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 2. Brand Selection -->
            <div class="col-lg-2 col-md-6">
                <div class="search-input-field">
                    <label class="search-input-label">
                        <i class="bi bi-building text-muted"></i> Brand
                    </label>
                    <select name="brand" class="search-input-control">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->slug }}" {{ $selectedBrand == $b->slug ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 3. Check-in Date -->
            <div class="col-lg-2 col-md-6 col-6">
                <div class="search-input-field">
                    <label class="search-input-label">
                        <i class="bi bi-calendar-event text-muted"></i> Check-in
                    </label>
                    <input type="date"
                           name="check_in"
                           id="widgetCheckIn"
                           class="search-input-control"
                           value="{{ $defaultCheckIn }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                </div>
            </div>

            <!-- 4. Check-out Date -->
            <div class="col-lg-2 col-md-6 col-6">
                <div class="search-input-field">
                    <label class="search-input-label">
                        <i class="bi bi-calendar-check text-muted"></i> Check-out
                    </label>
                    <input type="date"
                           name="check_out"
                           id="widgetCheckOut"
                           class="search-input-control"
                           value="{{ $defaultCheckOut }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required>
                </div>
            </div>

            <!-- 5. Guests -->
            <div class="col-lg-1 col-md-6 col-6">
                <div class="search-input-field">
                    <label class="search-input-label">
                        <i class="bi bi-people text-muted"></i> Tamu
                    </label>
                    <select name="guests" class="search-input-control">
                        @for($i = 1; $i <= 16; $i++)
                            <option value="{{ $i }}" {{ $defaultGuests == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i > 1 ? 'Org' : 'Org' }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- 6. Search Submit Button -->
            <div class="col-lg-2 col-md-6 col-6">
                <button type="submit" class="btn btn-ubu-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-search"></i>
                    <span>Cari Villa</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkIn = document.getElementById('widgetCheckIn');
        const checkOut = document.getElementById('widgetCheckOut');
        const form = document.getElementById('searchWidgetForm');

        if (checkIn && checkOut) {
            checkIn.addEventListener('change', function () {
                const inDate = new Date(this.value);
                inDate.setDate(inDate.getDate() + 1);
                const nextDay = inDate.toISOString().split('T')[0];
                checkOut.min = nextDay;
                if (checkOut.value <= this.value) {
                    checkOut.value = nextDay;
                }
            });

            form.addEventListener('submit', function (e) {
                if (new Date(checkOut.value) <= new Date(checkIn.value)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Tidak Sesuai',
                        text: 'Tanggal check-out harus lebih akhir dari tanggal check-in.',
                        confirmButtonColor: '#1b3b2b'
                    });
                }
            });
        }

        // Filter Pills toggle
        document.querySelectorAll('.search-filter-pill').forEach(btn => {
            btn.addEventListener('click', function () {
                const filter = this.dataset.filter;
                const poolInput = document.getElementById('filterPrivatePool');
                const syariahInput = document.getElementById('filterSyariah');

                document.querySelectorAll('.search-filter-pill').forEach(b => {
                    b.classList.remove('btn-dark');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-dark');

                if (filter === 'pool') {
                    poolInput.value = '1';
                    syariahInput.value = '';
                } else if (filter === 'syariah') {
                    syariahInput.value = '1';
                    poolInput.value = '';
                } else {
                    poolInput.value = '';
                    syariahInput.value = '';
                }
            });
        });
    });
</script>
@endpush
