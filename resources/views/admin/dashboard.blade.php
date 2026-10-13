@extends('layouts.admin')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Dashboard Operasional</h3>
        <p class="text-muted small mb-0">Ringkasan portfolio hospitality, konten aktif, dan prospek kemitraan terintegrasi.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.properties.create') }}" class="btn btn-sm btn-ubu-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Properti
        </a>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-ticket-perforated me-1"></i> Buat Promo
        </a>
    </div>
</div>

<!-- Stat Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="text-muted small fw-semibold text-uppercase">Brand Terdaftar</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['brands_count'] }}</div>
                <small class="text-success"><i class="bi bi-check-circle"></i> Ubu, Buruj, Glamping</small>
            </div>
            <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-tags-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="text-muted small fw-semibold text-uppercase">Total Properti</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['properties_count'] }}</div>
                <small class="text-muted">{{ $stats['published_properties_count'] }} Terpublikasi</small>
            </div>
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-houses-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="text-muted small fw-semibold text-uppercase">Promo Aktif</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['active_promotions_count'] }}</div>
                <small class="text-warning fw-semibold"><i class="bi bi-broadcast"></i> Tayang di Web</small>
            </div>
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="text-muted small fw-semibold text-uppercase">Prospek Kemitraan</div>
                <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['total_leads_count'] }}</div>
                @if($stats['new_leads_count'] > 0)
                    <small class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill"></i> {{ $stats['new_leads_count'] }} Perlu Ditindaklanjuti</small>
                @else
                    <small class="text-success"><i class="bi bi-check-all"></i> Semua Terfollow-up</small>
                @endif
            </div>
            <div class="stat-icon bg-danger-subtle text-danger">
                <i class="bi bi-building-up"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Partnership Leads -->
    <div class="col-lg-7">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-building-up me-2 text-primary"></i> Pengajuan Kemitraan Terbaru</h5>
                <a href="{{ route('admin.partnerships.index') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
            </div>

            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>No Referensi</th>
                            <th>Pemilik & Properti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLeads as $lead)
                            <tr>
                                <td>
                                    <span class="font-monospace small fw-bold text-dark">{{ $lead->reference_no }}</span>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $lead->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $lead->owner_name }}</div>
                                    <small class="text-muted">{{ $lead->property_name }} ({{ $lead->city }})</small>
                                </td>
                                <td>
                                    <span class="badge {{ $lead->pipeline_badge_class }} small">{{ ucfirst(str_replace('_', ' ', $lead->pipeline_status)) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.partnerships.show', $lead->id) }}" class="btn btn-sm btn-light border py-1 px-2">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4 small">
                                    Belum ada pengajuan kemitraan baru yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Audit Logs -->
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock-fill me-2 text-success"></i> Aktivitas Sistem & Audit</h5>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-link text-decoration-none">Semua Log</a>
            </div>

            <div class="p-3">
                <div class="list-group list-group-flush">
                    @forelse($recentLogs as $log)
                        <div class="list-group-item px-0 py-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-light text-dark border font-monospace small" style="font-size: 0.7rem;">{{ $log->action }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="small text-dark">{{ $log->description ?: 'Perubahan data sistem' }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Oleh: {{ $log->user?->name ?? 'System' }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4 small">Belum ada riwayat aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Property Overview -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-houses me-2 text-success"></i> Status Properti Terdaftar</h5>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-link text-decoration-none">Kelola Properti</a>
    </div>
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Nama Properti</th>
                    <th>Brand</th>
                    <th>SENTEC Property ID</th>
                    <th>Kapasitas</th>
                    <th>Tarif Estimasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($properties as $prop)
                    <tr>
                        <td class="fw-bold text-dark">{{ $prop->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $prop->brand?->name }}</span></td>
                        <td>
                            @if($prop->sentec_property_id)
                                <span class="badge bg-success-subtle text-success font-monospace">{{ $prop->sentec_property_id }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Belum Taut</span>
                            @endif
                        </td>
                        <td>{{ $prop->max_guests }} Tamu &bull; {{ $prop->bedrooms }} Kamar</td>
                        <td class="fw-bold text-success">{{ $prop->formatted_price }}</td>
                        <td>
                            <span class="badge {{ $prop->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($prop->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.properties.edit', $prop->id) }}" class="btn btn-sm btn-light border py-1 px-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
