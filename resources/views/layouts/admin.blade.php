<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Ubu Hospitality CMS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/branding/favicon.png') }}" type="image/png">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header d-flex align-items-center gap-2">
                <img src="{{ asset('images/branding/logo-dark.svg') }}" alt="Ubu Logo" height="36" class="bg-white p-1 rounded-2 shadow-sm">
                <div>
                    <div class="sidebar-brand-title">UBU HOSPITALITY</div>
                    <div class="sidebar-brand-badge">CMS PLATFORM</div>
                </div>
            </div>

            @php
                $pendingLeadsCount = \App\Models\PartnershipLead::where('pipeline_status', 'new')->count();
            @endphp

            <nav class="sidebar-nav">
                <div class="sidebar-heading">Menu Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>

                <div class="sidebar-heading">Hospitality & Aset</div>
                <a href="{{ route('admin.brands.index') }}" class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i> Manajemen Brand
                </a>
                <a href="{{ route('admin.properties.index') }}" class="sidebar-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                    <i class="bi bi-houses-fill"></i> Manajemen Properti
                </a>
                <a href="{{ route('admin.amenities.index') }}" class="sidebar-link {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-circle"></i> Fasilitas (Amenities)
                </a>

                <div class="sidebar-heading">Pemasaran & Konten</div>
                <a href="{{ route('admin.promotions.index') }}" class="sidebar-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                    <i class="bi bi-ticket-perforated-fill"></i> Promo & Penawaran
                </a>
                <a href="{{ route('admin.experiences.index') }}" class="sidebar-link {{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">
                    <i class="bi bi-compass-fill"></i> Experience & Aktivitas
                </a>
                <a href="{{ route('admin.blog.index') }}" class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i> Artikel & Blog
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-heart-fill"></i> Ulasan Tamu (Reviews)
                </a>

                <div class="sidebar-heading">Operasional & Kemitraan</div>
                <a href="{{ route('admin.partnerships.index') }}" class="sidebar-link {{ request()->routeIs('admin.partnerships.*') ? 'active' : '' }}">
                    <i class="bi bi-building-up"></i> Prospek Kemitraan
                    @if($pendingLeadsCount > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingLeadsCount }}</span>
                    @endif
                </a>

                <div class="sidebar-heading">Tata Kelola Web</div>
                <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-richtext"></i> Halaman & Section
                </a>
                <a href="{{ route('admin.navigations.index') }}" class="sidebar-link {{ request()->routeIs('admin.navigations.*') ? 'active' : '' }}">
                    <i class="bi bi-menu-button-wide"></i> Menu Navigasi
                </a>
                <a href="{{ route('admin.media.index') }}" class="sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Media Library
                </a>
                <a href="{{ route('admin.seo.index') }}" class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                    <i class="bi bi-signpost-split-fill"></i> SEO & 301 Redirect
                </a>

                <div class="sidebar-heading">Sistem & Keamanan</div>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Pengguna & Akses
                </a>
                <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill"></i> Audit Logs
                </a>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i> Pengaturan Sistem
                </a>
            </nav>
        </aside>

        <!-- Main Wrapper -->
        <div class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-light border d-md-none" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('d-none')">
                        <i class="bi bi-list"></i>
                    </button>
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-up-right-square me-1"></i> Buka Website Publik
                    </a>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block text-start">
                                <div class="fw-semibold small leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ auth()->user()->role?->name ?? 'Admin' }}</div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border shadow-sm rounded-3 p-2">
                            <li><a class="dropdown-item small" href="{{ route('admin.profile') }}"><i class="bi bi-person me-2"></i> Profil & Sandi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item small text-danger"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1b3b2b',
                timer: 3500
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#b91c1c'
            });
        @endif

        function confirmDelete(formId, message = 'Tindakan ini tidak dapat dibatalkan.') {
            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#b91c1c',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
