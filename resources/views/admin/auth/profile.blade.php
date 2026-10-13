@extends('layouts.admin')

@section('title', 'Profil Pengguna')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark font-serif mb-1">Pengaturan Akun & Profil</h3>
    <p class="text-muted small">Kelola informasi identitas akun dan perbarui kata sandi Anda secara berkala.</p>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf

                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center fs-3" style="width: 64px; height: 64px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">{{ $user->name }}</h5>
                        <span class="text-muted small">{{ $user->email }} &bull; Peran: <strong>{{ $user->role?->name ?? 'Admin' }}</strong></span>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Email (Tidak Dapat Diubah)</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                    </div>
                </div>

                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Ganti Kata Sandi (Opsional)</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Isi jika ingin mengganti sandi">
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                        @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-ubu-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
