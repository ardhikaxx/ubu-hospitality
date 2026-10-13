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

        <div class="booking-search-row align-items-stretch">
            <!-- 1. Destination / Brand -->
            <div class="search-col-destination">
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
            <div class="search-col-brand">
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
            <div class="search-col-checkin">
                <div class="search-input-field date-picker-field" id="checkInTrigger" style="cursor: pointer;">
                    <label class="search-input-label">
                        <i class="bi bi-calendar-event text-muted"></i> Check-in
                    </label>
                    <input type="text"
                           name="check_in"
                           id="widgetCheckIn"
                           class="search-input-control flatpickr-input"
                           value="{{ $defaultCheckIn }}"
                           placeholder="Pilih Tanggal"
                           readonly
                           required>
                </div>
            </div>

            <!-- 4. Check-out Date -->
            <div class="search-col-checkout">
                <div class="search-input-field date-picker-field" id="checkOutTrigger" style="cursor: pointer;">
                    <label class="search-input-label">
                        <i class="bi bi-calendar-check text-muted"></i> Check-out
                    </label>
                    <input type="text"
                           name="check_out"
                           id="widgetCheckOut"
                           class="search-input-control flatpickr-input"
                           value="{{ $defaultCheckOut }}"
                           placeholder="Pilih Tanggal"
                           readonly
                           required>
                </div>
            </div>

            <!-- 5. Guests Counter Popover (Airbnb / Traveloka Style) -->
            <div class="search-col-guests dropdown">
                <div class="search-input-field dropdown-toggle guest-picker-trigger"
                     id="guestsDropdownTrigger"
                     data-bs-toggle="dropdown"
                     data-bs-auto-close="outside"
                     aria-expanded="false"
                     role="button"
                     tabindex="0">
                    <label class="search-input-label">
                        <i class="bi bi-people text-muted"></i> Tamu
                    </label>
                    <div class="d-flex align-items-center justify-content-between">
                        <span id="guestsSummaryDisplay" class="fw-bold text-dark text-truncate" style="font-size: 0.95rem;">
                            {{ $defaultGuests }} Tamu
                        </span>
                        <i class="bi bi-chevron-down small text-muted ms-1"></i>
                    </div>
                </div>
                <input type="hidden" name="guests" id="guestsHiddenInput" value="{{ $defaultGuests }}">

                <!-- Airbnb-Style Counter Card -->
                <div class="dropdown-menu dropdown-menu-end p-3 p-md-4 border-0 guest-popover-card"
                     aria-labelledby="guestsDropdownTrigger"
                     style="min-width: 310px; z-index: 1050;">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <span class="fw-bold text-dark" style="font-size: 0.95rem;">Jumlah Tamu</span>
                        <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.72rem;">Maks. 16 Tamu</span>
                    </div>

                    <!-- Dewasa (Usia 13+) -->
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">Dewasa</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Usia 13 tahun ke atas</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn guest-stepper-btn" id="btnAdultMinus" aria-label="Kurangi Dewasa" {{ $defaultGuests <= 1 ? 'disabled' : '' }}>
                                <i class="bi bi-dash"></i>
                            </button>
                            <span id="countAdults" class="fw-bold text-dark text-center" style="width: 24px; font-size: 0.95rem;">{{ max(1, $defaultGuests) }}</span>
                            <button type="button" class="btn guest-stepper-btn" id="btnAdultPlus" aria-label="Tambah Dewasa">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Anak-anak (Usia 2-12) -->
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">Anak-anak</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Usia 2 – 12 tahun</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn guest-stepper-btn" id="btnChildMinus" aria-label="Kurangi Anak" disabled>
                                <i class="bi bi-dash"></i>
                            </button>
                            <span id="countChildren" class="fw-bold text-dark text-center" style="width: 24px; font-size: 0.95rem;">0</span>
                            <button type="button" class="btn guest-stepper-btn" id="btnChildPlus" aria-label="Tambah Anak">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="d-flex align-items-center justify-content-between pt-3">
                        <button type="button" class="btn btn-sm btn-link text-muted text-decoration-none p-0" id="btnGuestReset" style="font-size: 0.82rem;">
                            Reset
                        </button>
                        <button type="button" class="btn btn-ubu-primary btn-sm px-3 py-1 rounded-pill fw-semibold" id="btnGuestDone" style="font-size: 0.85rem;">
                            Selesai
                        </button>
                    </div>
                </div>
            </div>

            <!-- 6. Search Submit Button -->
            <div class="search-col-submit d-flex">
                <button type="submit" class="btn btn-ubu-primary w-100 h-100 py-3 d-flex align-items-center justify-content-center gap-2 text-nowrap" style="min-height: 56px; min-width: 130px;">
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
        // --- 1. Flatpickr Luxury Theme Integration ---
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
            rangeSeparator: " sampai ",
        };

        if (typeof flatpickr !== 'undefined') {
            let checkOutPicker;

            const checkInPicker = flatpickr("#widgetCheckIn", {
                locale: IndonesianLocale,
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j M Y",
                minDate: "today",
                defaultDate: "{{ $defaultCheckIn }}",
                disableMobile: true,
                onChange: function (selectedDates, dateStr) {
                    if (selectedDates.length > 0 && checkOutPicker) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        checkOutPicker.set('minDate', nextDay);
                        if (!checkOutPicker.selectedDates.length || checkOutPicker.selectedDates[0] <= selectedDates[0]) {
                            checkOutPicker.setDate(nextDay, true);
                        }
                        setTimeout(() => checkOutPicker.open(), 120);
                    }
                }
            });

            checkOutPicker = flatpickr("#widgetCheckOut", {
                locale: IndonesianLocale,
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j M Y",
                minDate: "{{ date('Y-m-d', strtotime($defaultCheckIn . ' +1 day')) }}",
                defaultDate: "{{ $defaultCheckOut }}",
                disableMobile: true,
            });

            document.getElementById('checkInTrigger')?.addEventListener('click', function (e) {
                if (e.target.tagName !== 'INPUT') {
                    checkInPicker.open();
                }
            });
            document.getElementById('checkOutTrigger')?.addEventListener('click', function (e) {
                if (e.target.tagName !== 'INPUT') {
                    checkOutPicker.open();
                }
            });
        }

        // --- 2. Interactive Counter Popover (Airbnb & Traveloka Style) ---
        let adults = parseInt(document.getElementById('countAdults')?.innerText || '{{ max(1, $defaultGuests) }}', 10);
        let children = parseInt(document.getElementById('countChildren')?.innerText || '0', 10);
        const maxGuests = 16;
        const minAdults = 1;

        const countAdultsEl = document.getElementById('countAdults');
        const countChildrenEl = document.getElementById('countChildren');
        const hiddenGuestsInput = document.getElementById('guestsHiddenInput');
        const guestsSummaryEl = document.getElementById('guestsSummaryDisplay');
        const btnAdultMinus = document.getElementById('btnAdultMinus');
        const btnAdultPlus = document.getElementById('btnAdultPlus');
        const btnChildMinus = document.getElementById('btnChildMinus');
        const btnChildPlus = document.getElementById('btnChildPlus');
        const btnGuestReset = document.getElementById('btnGuestReset');
        const btnGuestDone = document.getElementById('btnGuestDone');
        const dropdownTrigger = document.getElementById('guestsDropdownTrigger');

        function updateGuestUI() {
            const total = adults + children;
            if (hiddenGuestsInput) hiddenGuestsInput.value = total;
            if (countAdultsEl) countAdultsEl.textContent = adults;
            if (countChildrenEl) countChildrenEl.textContent = children;
            if (guestsSummaryEl) {
                guestsSummaryEl.textContent = total + ' Tamu';
            }

            if (btnAdultMinus) btnAdultMinus.disabled = adults <= minAdults;
            if (btnChildMinus) btnChildMinus.disabled = children <= 0;
            const isMax = total >= maxGuests;
            if (btnAdultPlus) btnAdultPlus.disabled = isMax;
            if (btnChildPlus) btnChildPlus.disabled = isMax;
        }

        btnAdultPlus?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (adults + children < maxGuests) {
                adults++;
                updateGuestUI();
            }
        });

        btnAdultMinus?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (adults > minAdults) {
                adults--;
                updateGuestUI();
            }
        });

        btnChildPlus?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (adults + children < maxGuests) {
                children++;
                updateGuestUI();
            }
        });

        btnChildMinus?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (children > 0) {
                children--;
                updateGuestUI();
            }
        });

        btnGuestReset?.addEventListener('click', function (e) {
            e.stopPropagation();
            adults = 2;
            children = 0;
            updateGuestUI();
        });

        btnGuestDone?.addEventListener('click', function (e) {
            e.stopPropagation();
            if (dropdownTrigger) {
                const dd = bootstrap.Dropdown.getInstance(dropdownTrigger);
                if (dd) dd.hide();
            }
        });

        updateGuestUI();

        // --- 3. Filter Pills toggle ---
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
