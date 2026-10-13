@extends('layouts.admin')

@section('title', 'Detail Prospek: ' . $lead->reference_no)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <h3 class="fw-bold text-dark font-serif mb-0">Ref: {{ $lead->reference_no }}</h3>
            @php
                $badgeClass = match($lead->pipeline_status) {
                    'new' => 'bg-info-subtle text-info',
                    'contacted' => 'bg-primary-subtle text-primary',
                    'survey_scheduled' => 'bg-warning-subtle text-warning',
                    'under_review' => 'bg-secondary-subtle text-secondary',
                    'negotiation' => 'bg-dark-subtle text-dark',
                    'approved' => 'bg-success-subtle text-success',
                    'rejected' => 'bg-danger-subtle text-danger',
                    default => 'bg-light text-dark'
                };
            @endphp
            <span class="badge {{ $badgeClass }} px-3 py-2 fs-6">
                {{ ucwords(str_replace('_', ' ', $lead->pipeline_status)) }}
            </span>
        </div>
        <p class="text-muted small mb-0">Diajukan pada {{ $lead->created_at->format('d F Y \p\u\k\u\l H:i') }} WIB</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.partnerships.index') }}" class="btn btn-outline-secondary btn-sm">
            &larr; Kembali ke Daftar
        </a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}?text=Halo%20{{ urlencode($lead->owner_name) }},%20kami%20dari%20Ubu%20Hospitality%20menindaklanjuti%20pengajuan%20kemitraan%20anda%20({{ $lead->reference_no }})." target="_blank" class="btn btn-success btn-sm">
            <i class="bi bi-whatsapp me-1"></i> Hubungi WhatsApp
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Owner & Property Details -->
    <div class="col-lg-7">
        <!-- Owner Info -->
        <div class="admin-card p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Informasi Pemilik & Kontak</h5>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Nama Lengkap</label>
                    <div class="fw-bold text-dark">{{ $lead->owner_name }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Nomor Telepon / WhatsApp</label>
                    <div class="fw-semibold">{{ $lead->phone }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Alamat Email</label>
                    <div>{{ $lead->email }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Domisili Pemilik</label>
                    <div>{{ $lead->owner_city ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Property Info -->
        <div class="admin-card p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Informasi Aset Properti / Lahan</h5>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Nama Properti</label>
                    <div class="fw-bold text-dark">{{ $lead->property_name ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Jenis Properti</label>
                    <div class="badge bg-light text-dark border">{{ ucfirst($lead->property_type) }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Status Fisik Aset</label>
                    <div>{{ ucwords(str_replace('_', ' ', $lead->property_status)) }}</div>
                </div>
                <div class="col-sm-6">
                    <label class="text-muted small d-block">Skema Kemitraan yang Diminati</label>
                    <div class="fw-semibold text-primary">{{ ucwords(str_replace('_', ' ', $lead->partnership_scheme)) }}</div>
                </div>
                <div class="col-12">
                    <label class="text-muted small d-block">Lokasi Alamat</label>
                    <div>{{ $lead->address }}</div>
                    <div class="text-muted small mt-1">Kota/Kab: {{ $lead->city }}, Provinsi: {{ $lead->province }}</div>
                </div>
                <div class="col-sm-4">
                    <label class="text-muted small d-block">Jumlah Kamar</label>
                    <div class="fw-bold">{{ $lead->total_rooms ?? '-' }} Unit / Kamar</div>
                </div>
                <div class="col-sm-4">
                    <label class="text-muted small d-block">Luas Tanah</label>
                    <div>{{ $lead->land_size ? $lead->land_size . ' m²' : '-' }}</div>
                </div>
                <div class="col-sm-4">
                    <label class="text-muted small d-block">Luas Bangunan</label>
                    <div>{{ $lead->building_size ? $lead->building_size . ' m²' : '-' }}</div>
                </div>
                <div class="col-12">
                    <label class="text-muted small d-block">Ekspektasi Penghasilan / Pesan Tambahan Pemilik</label>
                    <div class="p-3 bg-light rounded text-dark small mt-1">
                        {{ $lead->notes ?? 'Tidak ada pesan khusus dari pemilik.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Change History -->
        <div class="admin-card p-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Riwayat Perjalanan Status</h5>
            @if(!empty($lead->status_history) && is_array($lead->status_history))
                <ul class="list-unstyled mb-0">
                    @foreach($lead->status_history as $hist)
                        <li class="mb-3 ps-3 border-start border-2 border-primary position-relative">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-dark">{{ ucwords(str_replace('_', ' ', $hist['status'] ?? '')) }}</span>
                                <span class="text-muted small">{{ $hist['timestamp'] ?? '' }}</span>
                            </div>
                            <div class="text-muted small">Oleh: {{ $hist['by'] ?? 'Sistem' }}</div>
                            @if(!empty($hist['note']))
                                <div class="bg-light p-2 rounded small mt-1">{{ $hist['note'] }}</div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted small mb-0">Belum ada riwayat perubahan status.</p>
            @endif
        </div>
    </div>

    <!-- Right Column: Actions, Assignee, Notes -->
    <div class="col-lg-5">
        <!-- Update Pipeline Status -->
        <div class="admin-card p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Ubah Status Pipeline</h5>
            <form action="{{ route('admin.partnerships.status', $lead) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tahapan Pipeline Saat Ini</label>
                    <select name="pipeline_status" class="form-select" required>
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" {{ $lead->pipeline_status === $st ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $st)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan Perubahan (Opsional)</label>
                    <textarea name="status_note" rows="2" class="form-control" placeholder="Contoh: Sudah ditelepon, pemilik setuju jadwal survey tgl 20 Okt."></textarea>
                </div>
                <button type="submit" class="btn btn-ubu-primary w-100">
                    <i class="bi bi-arrow-repeat me-1"></i> Update Status Pipeline
                </button>
            </form>
        </div>

        <!-- Assignment & Internal Notes -->
        <div class="admin-card p-4">
            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Penugasan & Catatan Tim Internal</h5>
            <form action="{{ route('admin.partnerships.notes', $lead) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">PIC Penanggung Jawab (Assignee)</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">-- Belum Ditugaskan --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $lead->assigned_to == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan Tim Internal</label>
                    <textarea name="internal_notes" rows="6" class="form-control" placeholder="Tuliskan catatan internal mengenai hasil survey lapangan, proyeksi revenue sharing, atau kelayakan properti...">{{ old('internal_notes', $lead->internal_notes) }}</textarea>
                    <div class="form-text small">Catatan ini hanya dapat dibaca oleh tim Ubu Hospitality, tidak terlihat oleh calon mitra.</div>
                </div>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-save me-1"></i> Simpan Catatan Internal
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
