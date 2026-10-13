@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Pengguna CMS & Peran Akses</h3>
        <p class="text-muted small mb-0">Kelola akun administrator, manajer properti, staf konten, dan tingkat izin operasional.</p>
    </div>
    <button type="button" class="btn btn-ubu-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-person-plus me-1"></i> Tambah Pengguna Baru
    </button>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Peran (Role)</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th class="text-end pe-4" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-primary-subtle text-primary" style="font-size: 0.65rem;">Akun Anda</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="small text-muted">{{ $user->phone ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace">
                                {{ $user->role->name ?? 'Tanpa Role' }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-subtle text-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-muted">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna {{ $user->name }}?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Modal Edit User -->
                            <div class="modal fade text-start" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-serif">Edit Pengguna: {{ $user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row g-3">
                                                <div class="col-12">
                                                    <label class="form-label small">Nama Lengkap <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">Alamat Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Peran Akses (Role) <span class="text-danger">*</span></label>
                                                    <select name="role_id" class="form-select" required>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Nomor Telepon</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label small">Ubah Password (Kosongkan jika tidak diubah)</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="actUsr{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="actUsr{{ $user->id }}">Akun Aktif (Dapat Login)</label>
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
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada pengguna tambahan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="p-3 border-top">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-serif">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label class="form-label small">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Sarah Wijaya">
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="sarah@ubuhospitality.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Peran Akses (Role) <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="+62 812-...">
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Password Akun <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="newUsrActive" checked>
                            <label class="form-check-label small" for="newUsrActive">Akun Langsung Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-ubu-primary">Buat Akun Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
