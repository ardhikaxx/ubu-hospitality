@extends('layouts.admin')

@section('title', 'Audit Log Sistem & Keamanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Audit Trail & Riwayat Aktivitas</h3>
        <p class="text-muted small mb-0">Catatan kronologis seluruh perubahan data, publikasi, transaksi, dan aksi administratif.</p>
    </div>
</div>

<!-- Filter Bar -->
<div class="admin-card p-3 mb-4">
    <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="action" class="form-control border-start-0" placeholder="Filter aksi (misal: property.updated, brand.created)..." value="{{ request('action') }}">
            </div>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-secondary w-100">Filter Log</button>
        </div>
        <div class="col-md-3">
            @if(request()->filled('action'))
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-secondary w-100">Reset Filter</a>
            @endif
        </div>
    </form>
</div>

<div class="admin-card p-0">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 170px;">Waktu Kejadian</th>
                    <th>Pengguna</th>
                    <th>Aksi (Action)</th>
                    <th>Deskripsi Aktivitas</th>
                    <th>IP Address</th>
                    <th class="text-end pe-4" style="width: 90px;">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-muted small">
                            <i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $log->user->name ?? 'System / Anonymous' }}</div>
                            <div class="text-muted small">{{ $log->user->email ?? '-' }}</div>
                        </td>
                        <td>
                            @php
                                $badgeColor = 'bg-secondary-subtle text-secondary';
                                if (str_contains($log->action, 'created')) $badgeColor = 'bg-success-subtle text-success';
                                elseif (str_contains($log->action, 'deleted')) $badgeColor = 'bg-danger-subtle text-danger';
                                elseif (str_contains($log->action, 'updated')) $badgeColor = 'bg-primary-subtle text-primary';
                                elseif (str_contains($log->action, 'status')) $badgeColor = 'bg-warning-subtle text-warning';
                            @endphp
                            <span class="badge {{ $badgeColor }} font-monospace" style="font-size: 0.75rem;">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>
                            <div class="small text-dark">{{ $log->description }}</div>
                            @if($log->auditable_type)
                                <div class="text-muted small" style="font-size: 0.7rem;">
                                    {{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="small font-monospace text-muted">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                        </td>
                        <td class="text-end pe-4">
                            @if(!empty($log->old_values) || !empty($log->new_values))
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Modal JSON Values -->
                                <div class="modal fade text-start" id="logModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-serif">Detail Perubahan #{{ $log->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="small text-muted mb-2">Aksi: <code>{{ $log->action }}</code> &bull; Oleh: {{ $log->user->name ?? 'System' }}</p>
                                                <div class="row g-3">
                                                    @if(!empty($log->old_values))
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold text-danger small">Nilai Sebelumnya (Old Values):</h6>
                                                            <pre class="bg-light p-3 rounded small text-dark" style="max-height: 250px; overflow-y: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                        </div>
                                                    @endif
                                                    @if(!empty($log->new_values))
                                                        <div class="col-md-{{ !empty($log->old_values) ? '6' : '12' }}">
                                                            <h6 class="fw-bold text-success small">Nilai Baru (New Values):</h6>
                                                            <pre class="bg-light p-3 rounded small text-dark" style="max-height: 250px; overflow-y: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-check display-6 d-block mb-2"></i>
                            Belum ada riwayat aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="p-3 border-top">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
