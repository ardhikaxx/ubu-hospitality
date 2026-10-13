@extends('layouts.admin')

@section('title', 'Kelola Navigasi & Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Manajemen Menu Navigasi</h3>
        <p class="text-muted small mb-0">Kelola susunan link navigasi header, footer, dan menu mobile website.</p>
    </div>
    <button type="button" class="btn btn-ubu-primary" data-bs-toggle="modal" data-bs-target="#createNavModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Item Menu
    </button>
</div>

<div class="row g-4">
    @foreach($menus as $menu)
        <div class="col-12">
            <div class="admin-card p-0">
                <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-0 font-serif">{{ $menu->name }}</h5>
                        <span class="badge bg-secondary font-monospace">{{ $menu->code }}</span>
                        <span class="text-muted small ms-2">{{ $menu->description }}</span>
                    </div>
                    <span class="badge bg-light text-dark border">{{ $menu->allItems->count() }} item</span>
                </div>

                <div class="table-responsive">
                    <table class="table admin-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Judul (ID)</th>
                                <th>Judul (EN)</th>
                                <th>URL Link</th>
                                <th>Target</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menu->allItems as $item)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $item->title_id }}</td>
                                    <td class="text-muted">{{ $item->title_en }}</td>
                                    <td><code class="text-muted">{{ $item->url }}</code></td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $item->target }}</span>
                                    </td>
                                    <td>{{ $item->sort_order }}</td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success-subtle text-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editNavModal{{ $item->id }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.navigations.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus menu item ini?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Edit Modal for this item -->
                                        <div class="modal fade text-start" id="editNavModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-serif">Edit Item: {{ $item->title_id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.navigations.update', $item) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label small">Judul (ID) <span class="text-danger">*</span></label>
                                                                <input type="text" name="title_id" class="form-control" value="{{ $item->title_id }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small">Judul (EN) <span class="text-danger">*</span></label>
                                                                <input type="text" name="title_en" class="form-control" value="{{ $item->title_en }}" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label small">URL / Path <span class="text-danger">*</span></label>
                                                                <input type="text" name="url" class="form-control" value="{{ $item->url }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small">Target Tab</label>
                                                                <select name="target" class="form-select">
                                                                    <option value="_self" {{ $item->target === '_self' ? 'selected' : '' }}>Tab Sama (_self)</option>
                                                                    <option value="_blank" {{ $item->target === '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small">Urutan Tampilan</label>
                                                                <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}">
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="act{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                                                    <label class="form-check-label small" for="act{{ $item->id }}">Status Aktif</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-ubu-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada item dalam menu ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Create Item -->
<div class="modal fade" id="createNavModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-serif">Tambah Item Navigasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.navigations.store') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label small">Pilih Kelompok Menu <span class="text-danger">*</span></label>
                        <select name="menu_id" class="form-select" required>
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Judul Menu (Indonesia) <span class="text-danger">*</span></label>
                        <input type="text" name="title_id" class="form-control" placeholder="Contoh: Tentang Kami" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Judul Menu (Inggris) <span class="text-danger">*</span></label>
                        <input type="text" name="title_en" class="form-control" placeholder="Contoh: About Us" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small">URL / Path Tujuan <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" placeholder="Contoh: /about atau https://..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Target Tab</label>
                        <select name="target" class="form-select">
                            <option value="_self">Tab Sama (_self)</option>
                            <option value="_blank">Tab Baru (_blank)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Urutan Tampilan</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="newItemActive" checked>
                            <label class="form-check-label small" for="newItemActive">Aktifkan Langsung di Tampilan Web</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary">Simpan Item Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
