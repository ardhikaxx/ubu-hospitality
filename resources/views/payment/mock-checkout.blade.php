@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="max-w-xl mx-auto" style="max-width: 600px;">
        <div class="card border rounded-4 p-4 p-md-5 shadow-lg bg-white">
            <div class="text-center mb-4">
                <span class="badge bg-warning text-dark text-uppercase px-3 py-1 mb-2">Simulasi Gateway DOKU</span>
                <h3 class="font-serif fw-bold text-dark">Halaman Pembayaran Simulasi</h3>
                <p class="text-muted small">Mode pengujian terkontrol integrasi pembayaran DOKU.</p>
            </div>

            <div class="p-3 rounded-3 bg-light border mb-4">
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>Nomor Invoice:</span>
                    <strong class="text-dark font-monospace">{{ $transaction->invoice_number }}</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>Nama Tamu:</span>
                    <strong class="text-dark">{{ $transaction->customer_name }}</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>Email & WhatsApp:</span>
                    <strong class="text-dark">{{ $transaction->customer_email }} ({{ $transaction->customer_phone }})</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>Metode:</span>
                    <strong class="text-dark">{{ $transaction->payment_channel }}</strong>
                </div>
                <div class="d-flex justify-content-between small text-muted mb-2">
                    <span>Status Saat Ini:</span>
                    <span class="badge {{ $transaction->status_badge_class }}">{{ strtoupper($transaction->status) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                    <span class="fw-bold text-dark">Total Tagihan:</span>
                    <span class="fs-4 fw-bold text-success">{{ $transaction->formatted_amount }}</span>
                </div>
            </div>

            @if($transaction->status === 'paid')
                <div class="alert alert-success border-0 text-center py-3 mb-4">
                    <i class="bi bi-check-circle-fill fs-2 d-block text-success mb-1"></i>
                    <strong>Pembayaran Sukses Terverifikasi!</strong>
                    <div class="small text-muted">Dibayar pada: {{ $transaction->paid_at?->format('d M Y H:i:s') }}</div>
                </div>

                <a href="{{ route('home') }}" class="btn btn-ubu-primary w-100 py-2">
                    Kembali ke Beranda
                </a>
                <div class="mb-4 text-center">
                    <small class="text-muted d-block mb-2">Metode Pembayaran Resmi Yang Didukung:</small>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        @foreach(['bca', 'bni', 'mandiri', 'bri', 'mastercard', 'link', 'indomaret', 'alfamart'] as $brand)
                            <div class="bg-light border rounded px-2 py-1 d-flex align-items-center justify-content-center" style="height: 30px; width: 48px;">
                                <img src="{{ asset('images/payments/' . $brand . '.webp') }}" alt="{{ $brand }}" style="max-height: 18px; max-width: 40px; object-fit: contain;">
                            </div>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('payment.mock-complete', $transaction->invoice_number) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ubu-primary w-100 py-3 fw-bold mb-3 shadow">
                        <i class="bi bi-credit-card-2-front-fill me-1"></i> Selesaikan Pembayaran Simulasi
                    </button>
                </form>

                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                        Batalkan dan kembali ke beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
