<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke CMS Platform | Ubu Hospitality</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">

    <style>
        body {
            font-family: var(--font-body);
            background-color: var(--ubu-primary, #0085a2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: var(--radius-xl);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background-color: #16201b;
            color: #ffffff;
            padding: 2.25rem 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-1 mb-2">Hospitality CMS</span>
            <h3 class="font-serif fw-bold text-white mb-1">UBU HOSPITALITY</h3>
            <p class="text-white-50 small mb-0">Panel Administrasi & Manajemen Aset</p>
        </div>

        <div class="p-4 p-md-5">
            @if(session('error'))
                <div class="alert alert-danger small py-2 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning small py-2 mb-4">
                    {{ session('warning') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', 'admin@ubuhospitality.com') }}" required autofocus placeholder="admin@ubuhospitality.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-dark">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label small text-muted" for="rememberMe">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-ubu-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard
                </button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted d-block">Default dev login: <code>admin@ubuhospitality.com</code> / <code>AdminUbu2026!</code></small>
                <a href="{{ url('/') }}" class="text-decoration-none text-muted small mt-2 d-inline-block">
                    &larr; Kembali ke Website Publik
                </a>
            </div>
        </div>
    </div>
</body>
</html>
