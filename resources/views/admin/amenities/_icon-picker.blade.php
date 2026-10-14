{{-- Visual Icon Picker untuk Fasilitas (orang awam: tinggal klik icon) --}}
{{-- Parameter: $icons (array class+label), $selected (string), $prefix (string unik) --}}
<div class="icon-picker" data-picker="{{ $prefix }}">
    <input type="hidden" name="icon" id="{{ $prefix }}-input" value="{{ $selected }}" required>

    <div class="d-flex align-items-center gap-3 mb-2 p-2 border rounded-3 bg-light">
        <div id="{{ $prefix }}-preview"
             class="bg-white border rounded-3 d-flex align-items-center justify-content-center text-success flex-shrink-0"
             style="width: 52px; height: 52px; font-size: 1.6rem;">
            <i class="{{ $selected }}"></i>
        </div>
        <div class="min-w-0">
            <div class="small text-muted">Icon terpilih, klik gambar di bawah untuk ganti:</div>
            <code id="{{ $prefix }}-label" class="fw-bold">{{ $selected }}</code>
        </div>
    </div>

    <input type="search"
           id="{{ $prefix }}-search"
           class="form-control form-control-sm mb-2"
           placeholder="Cari icon… misal: wifi, kolam, parkir, ac"
           autocomplete="off">

    <div class="icon-picker-grid" id="{{ $prefix }}-grid" role="listbox" aria-label="Pilihan icon fasilitas">
        @foreach($icons as $ic)
            <button type="button"
                    class="icon-picker-opt {{ $selected === $ic['class'] ? 'active' : '' }}"
                    data-icon="{{ $ic['class'] }}"
                    data-keywords="{{ strtolower($ic['label'].' '.$ic['class']) }}"
                    title="{{ $ic['label'] }} ({{ $ic['class'] }})"
                    role="option"
                    aria-selected="{{ $selected === $ic['class'] ? 'true' : 'false' }}">
                <i class="{{ $ic['class'] }}"></i>
                <span>{{ $ic['label'] }}</span>
            </button>
        @endforeach
    </div>

    <details class="mt-2">
        <summary class="small text-muted" style="cursor: pointer;">Pakai kode manual (opsional, untuk lanjutan)</summary>
        <input type="text"
               id="{{ $prefix }}-custom"
               class="form-control form-control-sm font-monospace mt-1"
               value="{{ $selected }}"
               placeholder="contoh: bi-wifi">
        <div class="form-text">Hanya jika icon yang dicari tidak ada di daftar. Lihat daftar lengkap di Bootstrap Icons.</div>
    </details>
</div>
