@extends('layouts.admin')

@section('title', 'Pengaturan Sistem & Integrasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark font-serif mb-1">Pengaturan Konfigurasi Platform</h3>
        <p class="text-muted small mb-0">Kelola identitas badan usaha, kontak WhatsApp, integrasi booking SENTEC & payment DOKU.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="row g-4">
        <!-- General Company Settings -->
        <div class="col-lg-6">
            <div class="admin-card p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">
                    <i class="bi bi-building me-2 text-primary"></i> Profil Perusahaan & Master Brand
                </h5>
                @if(isset($settings['general']))
                    @foreach($settings['general'] as $setting)
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ $setting->description ?? $setting->key }}</label>
                            <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                            <div class="form-text small font-monospace text-muted">{{ $setting->key }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Contact & Location Settings -->
        <div class="col-lg-6">
            <div class="admin-card p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">
                    <i class="bi bi-telephone me-2 text-success"></i> Kontak & Lokasi Kantor Pusat
                </h5>
                @if(isset($settings['contact']))
                    @foreach($settings['contact'] as $setting)
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ $setting->description ?? $setting->key }}</label>
                            @if(str_contains($setting->key, 'address'))
                                <textarea name="{{ $setting->key }}" rows="2" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                            @endif
                            <div class="form-text small font-monospace text-muted">{{ $setting->key }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="col-lg-6">
            <div class="admin-card p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">
                    <i class="bi bi-share me-2 text-info"></i> Media Sosial Resmi
                </h5>
                @if(isset($settings['social']))
                    @foreach($settings['social'] as $setting)
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ $setting->description ?? $setting->key }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                            </div>
                            <div class="form-text small font-monospace text-muted">{{ $setting->key }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- External Integrations Settings -->
        <div class="col-lg-6">
            <div class="admin-card p-4 h-100">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2 font-serif">
                    <i class="bi bi-cpu me-2 text-warning"></i> Mode Integrasi Eksternal (SENTEC & DOKU)
                </h5>
                @if(isset($settings['integrations']))
                    @foreach($settings['integrations'] as $setting)
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ $setting->description ?? $setting->key }}</label>
                            @if($setting->type === 'boolean')
                                <select name="{{ $setting->key }}" class="form-select">
                                    <option value="1" {{ old($setting->key, $setting->value) == '1' ? 'selected' : '' }}>Aktif (Enabled / Simulation Mode)</option>
                                    <option value="0" {{ old($setting->key, $setting->value) == '0' ? 'selected' : '' }}>Nonaktif (Disabled / Live Direct)</option>
                                </select>
                            @else
                                <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                            @endif
                            <div class="form-text small font-monospace text-muted">{{ $setting->key }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="text-end mt-4 mb-5">
        <button type="submit" class="btn btn-ubu-primary btn-lg px-5 shadow-sm">
            <i class="bi bi-save me-2"></i> Simpan Seluruh Pengaturan
        </button>
    </div>
</form>
@endsection
