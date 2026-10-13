@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')

@section('content')
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
                                            <label class="form-label">Icon Bootstrap (contoh: bi-wifi, bi-water)</label>
                                            <input type="text" name="icon" class="form-control font-monospace" value="{{ $a->icon }}" required>
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
                        <label class="form-label">Icon Bootstrap</label>
                        <input type="text" name="icon" class="form-control font-monospace" value="bi-check2-circle" required>
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
