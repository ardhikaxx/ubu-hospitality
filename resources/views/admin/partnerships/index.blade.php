@extends('layouts.admin')

@section('title', 'Pipeline Kemitraan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Pipeline Prospek Kemitraan</h3>
        <p class="text-muted small mb-0">Kelola calon mitra pemilik villa / lahan dan tindak lanjut penawaran bagi hasil atau sewa kelola.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.partnerships.export') }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="admin-card p-3 mb-4">
    <form action="{{ route('admin.partnerships.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="Cari ref no, nama pemilik, properti, telepon..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Tahapan Pipeline</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $st)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">Filter</button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.partnerships.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>
</div>

<!-- Table Leads -->
<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Ref No</th>
                    <th>Nama Pemilik</th>
                    <th>Detail Properti</th>
                    <th>Skema Kerjasama</th>
                    <th>Status Pipeline</th>
                    <th>PIC Assignee</th>
                    <th>Tanggal Masuk</th>
                    <th class="text-end pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr>
                        <td>
                            <a href="{{ route('admin.partnerships.show', $lead) }}" class="fw-bold font-monospace text-decoration-none text-dark">
                                {{ $lead->reference_no }}
                            </a>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $lead->owner_name }}</div>
                            <div class="text-muted small">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="text-muted text-decoration-none me-2">
                                    <i class="bi bi-whatsapp text-success"></i> {{ $lead->phone }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $lead->property_name ?? 'Properti Belum Bernama' }}</div>
                            <div class="text-muted small">
                                <i class="bi bi-geo-alt"></i> {{ $lead->city }}, {{ $lead->province }} 
                                &bull; {{ $lead->total_rooms ?? '?' }} Kamar
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ ucwords(str_replace('_', ' ', $lead->partnership_scheme)) }}
                            </span>
                        </td>
                        <td>
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
                            <span class="badge {{ $badgeClass }}">
                                {{ ucwords(str_replace('_', ' ', $lead->pipeline_status)) }}
                            </span>
                        </td>
                        <td>
                            <span class="small text-muted">
                                {{ $lead->assignee->name ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="small text-muted">{{ $lead->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.partnerships.show', $lead) }}" class="btn btn-sm btn-outline-secondary">
                                Review &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-6 d-block mb-2"></i>
                            Tidak ada pengajuan kemitraan yang cocok dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
        <div class="p-3 border-top">
            {{ $leads->links() }}
        </div>
    @endif
</div>
@endsection
