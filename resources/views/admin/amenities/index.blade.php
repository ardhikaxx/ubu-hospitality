@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')

@section('content')
@php
    $iconOptions = [
        ['class' => 'bi-water', 'label' => 'Kolam'],
        ['class' => 'bi-cup-hot', 'label' => 'Sarapan'],
        ['class' => 'bi-cup-straw', 'label' => 'Minuman'],
        ['class' => 'bi-egg-fried', 'label' => 'Dapur'],
        ['class' => 'bi-fire', 'label' => 'BBQ / Api'],
        ['class' => 'bi-wifi', 'label' => 'WiFi'],
        ['class' => 'bi-tv', 'label' => 'TV'],
        ['class' => 'bi-snow', 'label' => 'AC'],
        ['class' => 'bi-droplet-half', 'label' => 'Air Hangat'],
        ['class' => 'bi-shower', 'label' => 'Shower'],
        ['class' => 'bi-lightbulb', 'label' => 'Lampu'],
        ['class' => 'bi-plug', 'label' => 'Colokan'],
        ['class' => 'bi-door-open', 'label' => 'Pintu Privat'],
        ['class' => 'bi-p-circle', 'label' => 'Parkir'],
        ['class' => 'bi-car-front', 'label' => 'Mobil'],
        ['class' => 'bi-bicycle', 'label' => 'Sepeda'],
        ['class' => 'bi-airplane', 'label' => 'Antar Bandara'],
        ['class' => 'bi-geo-alt', 'label' => 'Lokasi'],
        ['class' => 'bi-person-check', 'label' => 'Butler'],
        ['class' => 'bi-bell', 'label' => 'Resepsionis'],
        ['class' => 'bi-clock', 'label' => '24 Jam'],
        ['class' => 'bi-key', 'label' => 'Kunci'],
        ['class' => 'bi-telephone', 'label' => 'Telepon'],
        ['class' => 'bi-shield-check', 'label' => 'Keamanan'],
        ['class' => 'bi-camera-video', 'label' => 'CCTV'],
        ['class' => 'bi-compass', 'label' => 'Kiblat'],
        ['class' => 'bi-book', 'label' => 'Quran / Buku'],
        ['class' => 'bi-moon-stars', 'label' => 'Nyaman'],
        ['class' => 'bi-house-heart', 'label' => 'Villa'],
        ['class' => 'bi-tree', 'label' => 'Taman'],
        ['class' => 'bi-flower1', 'label' => 'Bunga'],
        ['class' => 'bi-sun', 'label' => 'Outdoor'],
        ['class' => 'bi-umbrella', 'label' => 'Payung'],
        ['class' => 'bi-life-preserver', 'label' => 'Pelampung'],
        ['class' => 'bi-activity', 'label' => 'Gym'],
        ['class' => 'bi-controller', 'label' => 'Game'],
        ['class' => 'bi-music-note', 'label' => 'Musik'],
        ['class' => 'bi-shop', 'label' => 'Toko'],
        ['class' => 'bi-suitcase', 'label' => 'Koper'],
        ['class' => 'bi-people', 'label' => 'Keluarga'],
        ['class' => 'bi-star', 'label' => 'Bintang'],
        ['class' => 'bi-heart', 'label' => 'Favorit'],
        ['class' => 'bi-gem', 'label' => 'Premium'],
        ['class' => 'bi-check2-circle', 'label' => 'Centang'],
    ];
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Manajemen Fasilitas (Amenities)</h3>
        <p class="text-muted small mb-0">Kelola master data fasilitas villa seperti Private Pool, Floating Breakfast, WiFi, dan Syariah.</p>
    </div>
    <button type="button" class="btn btn-ubu-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createAmenityModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Fasilitas
    </button>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Nama Fasilitas (ID)</th>
                    <th>Nama Fasilitas (EN)</th>
                    <th>Kategori</th>
                    <th>Digunakan di Properti</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($amenities as $a)
                    <tr>
                        <td style="width: 50px;">
                            <div class="rounded-circle bg-light p-2 d-inline-flex align-items-center justify-content-center text-success" style="width: 36px; height: 36px;">
                                <i class="{{ $a->icon ?: 'bi-check2' }} fs-5"></i>
                            </div>
                        </td>
                        <td class="fw-bold text-dark">{{ $a->name_id }}</td>
                        <td class="text-muted">{{ $a->name_en }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($a->category) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-dark">{{ $a->properties_count }} Properti</span>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-light border py-1 px-2" data-bs-toggle="modal" data-bs-target="#editAmenityModal{{ $a->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.amenities.destroy', $a->id) }}" method="POST" class="d-inline" id="deleteAmenity{{ $a->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-light border py-1 px-2 text-danger" onclick="confirmDelete('deleteAmenity{{ $a->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editAmenityModal{{ $a->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.amenities.update', $a->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title font-serif fw-bold">Edit Fasilitas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama (Indonesia) <span class="text-danger">*</span></label>
                                            <input type="text" name="name_id" class="form-control" value="{{ $a->name_id }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama (Inggris) <span class="text-danger">*</span></label>
                                            <input type="text" name="name_en" class="form-control" value="{{ $a->name_en }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kategori</label>
                                            <select name="category" class="form-select" required>
                                                <option value="general" {{ $a->category === 'general' ? 'selected' : '' }}>Umum</option>
                                                <option value="room" {{ $a->category === 'room' ? 'selected' : '' }}>Kamar / Ruangan</option>
                                                <option value="outdoor" {{ $a->category === 'outdoor' ? 'selected' : '' }}>Outdoor / Kolam</option>
                                                <option value="service" {{ $a->category === 'service' ? 'selected' : '' }}>Layanan Butler / F&B</option>
                                                <option value="syariah" {{ $a->category === 'syariah' ? 'selected' : '' }}>Syariah & Ibadah</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Icon Fasilitas <span class="text-danger">*</span> <span class="fw-normal text-muted small">— tinggal klik gambar</span></label>
                                            @include('admin.amenities._icon-picker', ['icons' => $iconOptions, 'selected' => $a->icon ?: 'bi-check2-circle', 'prefix' => 'icon-edit-'.$a->id])
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Urutan</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ $a->sort_order }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-ubu-primary btn-sm">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createAmenityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.amenities.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-serif fw-bold">Tambah Fasilitas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama (Indonesia) <span class="text-danger">*</span></label>
                        <input type="text" name="name_id" class="form-control" required placeholder="Contoh: Private Swimming Pool">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama (Inggris) <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" required placeholder="Contoh: Private Swimming Pool">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option value="outdoor">Outdoor / Kolam</option>
                            <option value="general">Umum</option>
                            <option value="room">Kamar / Ruangan</option>
                            <option value="service">Layanan Butler / F&B</option>
                            <option value="syariah">Syariah & Ibadah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Fasilitas <span class="text-danger">*</span> <span class="fw-normal text-muted small">— tinggal klik gambar</span></label>
                        @include('admin.amenities._icon-picker', ['icons' => $iconOptions, 'selected' => 'bi-water', 'prefix' => 'icon-create'])
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-picker-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(76px, 1fr));
        gap: 6px;
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px;
        background: #fff;
    }
    .icon-picker-opt {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        padding: 8px 4px;
        min-height: 64px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .icon-picker-opt i {
        font-size: 1.35rem;
        line-height: 1;
        color: #334155;
    }
    .icon-picker-opt span {
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748b;
        line-height: 1.1;
        text-align: center;
    }
    .icon-picker-opt:hover {
        border-color: var(--ubu-primary, #0085a2);
        background: var(--ubu-primary-light, #e8f5f8);
    }
    .icon-picker-opt:hover i {
        color: var(--ubu-primary, #0085a2);
    }
    .icon-picker-opt.active {
        border-color: var(--ubu-primary, #0085a2);
        background: var(--ubu-primary-light, #e8f5f8);
        box-shadow: 0 0 0 2px rgba(0, 133, 162, 0.2);
    }
    .icon-picker-opt.active i {
        color: var(--ubu-primary, #0085a2);
    }
    .icon-picker-opt.active span {
        color: var(--ubu-primary, #0085a2);
    }
    .icon-picker-opt.d-none {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.icon-picker').forEach(function (picker) {
        var prefix = picker.getAttribute('data-picker');
        var hiddenInput = document.getElementById(prefix + '-input');
        var preview = document.getElementById(prefix + '-preview');
        var label = document.getElementById(prefix + '-label');
        var search = document.getElementById(prefix + '-search');
        var custom = document.getElementById(prefix + '-custom');
        var grid = document.getElementById(prefix + '-grid');
        if (!hiddenInput || !grid) {
            return;
        }
        var buttons = Array.prototype.slice.call(grid.querySelectorAll('.icon-picker-opt'));

        function setSelected(iconClass) {
            hiddenInput.value = iconClass;
            if (label) {
                label.textContent = iconClass;
            }
            if (preview) {
                preview.innerHTML = '<i class="' + iconClass + '"></i>';
            }
            if (custom && custom.value !== iconClass) {
                custom.value = iconClass;
            }
            buttons.forEach(function (btn) {
                var isActive = btn.getAttribute('data-icon') === iconClass;
                btn.classList.toggle('active', isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
        }

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                setSelected(btn.getAttribute('data-icon'));
            });
        });

        if (search) {
            search.addEventListener('input', function () {
                var q = search.value.trim().toLowerCase();
                buttons.forEach(function (btn) {
                    var hay = btn.getAttribute('data-keywords') || '';
                    btn.classList.toggle('d-none', q !== '' && hay.indexOf(q) === -1);
                });
            });
        }

        if (custom) {
            custom.addEventListener('change', function () {
                var v = custom.value.trim();
                if (v !== '') {
                    setSelected(v);
                }
            });
        }

        // Sinkronkan tampilan awal (misal data lama tidak ada di daftar)
        setSelected(hiddenInput.value || 'bi-check2-circle');
    });
});
</script>
@endpush
