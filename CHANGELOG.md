# 📋 Changelog

Semua perubahan penting dan riwayat pengembangan sistem **Ubu Hospitality Platform & Multi-Brand Property Management CMS** didokumentasikan dalam file ini.

Format pencatatan mengacu pada [Keep a Changelog](https://keepachangelog.com/id/1.0.0/) dan mematuhi [Semantic Versioning (SemVer)](https://semver.org/).

---

## [1.3.0] - 2026-10-14
### 🎨 UI/UX Responsif & Draw Menu Modern
- **Mobile Navbar & Modern Draw Menu**:
  - Mengurangi padding vertikal header pada mobile hingga ~35% agar lebih ringkas dan tidak menutupi visual hero.
  - Desain tombol aksi mobile simetris: tombol pencarian cepat (*search pill*) dan tombol drawer menu dengan 3 garis animasi hamburger ramping (*animated burger bars*).
  - Merancang ulang Offcanvas Draw Menu mobile dengan tema luxury hospitality:
    - Header brand Ubu Hospitality dengan tombol tutup bulat elegan.
    - Kartu pencarian instan (*quick search card*) yang langsung menghubungkan pengunjung ke daftar villa.
    - Kelompok navigasi berikon warna Teal (`#0085a2`), panah chevron berputar halus 180°, dan sub-link dengan garis batas elegan.
    - Footer drawer lengkap dengan *segmented language toggle* (ID / EN), tombol *Cek Ketersediaan & Booking*, tombol langsung *Customer Service WhatsApp*, serta tautan media sosial resmi.
    - Skrip auto-close saat pengguna mengklik tautan anchor section di halaman yang sama.
- **Admin CMS Sidebar Proporsional**:
  - Standarisasi lebar sidebar menjadi 270px dengan layout `position: sticky; top: 0; height: 100vh;` pada desktop.
  - Menyelaraskan warna latar menjadi Charcoal Natural `#1e2428` dengan pembatas halus `rgba(255,255,255,0.07)`.
  - Item link navigasi menggunakan padding proporsional (`0.58rem 0.85rem`), sudut lengkung 8px, dan active state berlatar Teal Ubu dengan bayangan elevasi.
  - Penambahan kartu user profile di bagian bawah sidebar (avatar inisial, nama admin, role, dan tombol pintasan pengaturan akun).
  - Mode mobile/tablet (`< 992px`): Berubah menjadi *Offcanvas Slide Drawer* halus dengan *backdrop blur overlay* dan tombol close silang modern.
- **Sidebar Filter Properti Publik (`/stay`)**:
  - Pada desktop (`>= 992px`): Kartu filter sidebar dibuat `sticky-top: 85px` agar tetap melayang sejajar saat menelusuri puluhan properti.
  - Pada mobile/tablet (`< 992px`): Mengganti tumpukan form panjang di atas listing dengan *Mobile Filter Action Bar* minimalis dan *Offcanvas Filter Drawer*.
- **Pengujian & Validasi**:
  - Suite pengujian otomatis Pest meningkat menjadi 42 tests dan 266 assertions (100% passing).

---

## [1.2.0] - 2026-10-14
### 🖼️ Sistem Upload Media Tanpa Symlink & Penyelarasan Destinasi
- **Sistem Upload Media Mandiri (Tanpa `storage:link`)**:
  - Implementasi `ImageUploadService` untuk memproses unggahan file secara otomatis.
  - Fitur kompresi otomatis ke format `.webp`, resize gambar (maksimal lebar 1920px), dan preservasi transparansi alpha pada PNG/WebP.
  - Penyimpanan ganda (*dual-storage*) ke `public/uploads/{folder}/` dan `storage/uploads/{folder}/`.
  - Pembuatan rute streaming langsung `GET /uploads/{folder}/{filename}` dengan proteksi *path traversal*, deteksi MIME type dinamis, dan header performa tinggi (`Cache-Control: immutable, max-age=31536000`).
  - Rute fallback `GET /storage/{path}` untuk kompatibilitas aset tanpa symlink.
  - Penggantian (*replacement*) otomatis dan penghapusan fisik file lama dari disk saat update/destroy di seluruh modul admin (Media, Properti, Brand, Blog, Experience, Promosi).
- **Penyelarasan Foto Destinasi "Jelajahi Lokasi"**:
  - Menyiapkan foto landmark autentik lokal beresolusi tinggi (rasio 4:3) untuk kawasan:
    - **Sleman**: Kemegahan Candi Prambanan (`public/images/destinations/sleman.jpg`).
    - **Kaliurang**: Panorama Lereng Gunung Merapi dari Kaliurang (`public/images/destinations/kaliurang.jpg`).
    - **Bantul**: Suasana Pantai Parangtritis Bantul (`public/images/destinations/bantul.jpg`).
    - **Kota Yogyakarta**: Monumen Tugu Pal Putih Yogyakarta (`public/images/destinations/kota-yogyakarta.jpg`).
  - Pembaruan database dan seeder `BrandsAndPropertiesSeeder.php` dengan data lokal.

---

## [1.1.0] - 2026-10-13
### 🌐 Sinkronisasi Konten Asli & Standarisasi Tema Warna Natural
- **Sinkronisasi Data Asli Ubu Villa**:
  - Unduh dan integrasikan logo Partner Pembayaran resmi (BCA, BNI, Mandiri, BRI, BRIVA, Mastercard, AMEX, ATM Bersama, Prima, LinkAja, Indomaret, Alfamart).
  - Tautkan video embed YouTube 360° dan Google Maps interaktif pada detail properti.
  - Sinkronkan artikel blog panduan perjalanan dan daftar FAQ asli.
  - Sinkronkan kontak resmi (WhatsApp 0823-2000-3297 dan alamat Headquarter Sleman).
- **Halaman Baru**:
  - Halaman **Celebrity Staycation** (`/celebrity`): Galeri kunjungan figur publik terkemuka.
  - Halaman **Special Packages** (`/packages`): Paket In-Villa BBQ, Floating Breakfast, Spa, Photoshoot, dan Jeep Tour.
  - Halaman **Life at Ubu** (`/life-at-ubu`), **CSR & Keberlanjutan** (`/csr`), dan **Karir** (`/career`).
- **Penghapusan Total Warna Coklat & Biru Dongker**:
  - Menghilangkan kode warna coklat/tan (`#aa8453`, `#8f6c3f`, `#b45309`) dan biru dongker (`#0b1a20`).
  - Menerapkan palet warna alami: Deep Ocean Teal (`#0085a2`), Sun Gold (`#f1c40f`), dan Natural Charcoal (`#222222`).
  - Menghapus gradasi warna berlebih (*no gradients*) demi estetika minimalis modern.
- **URL Redirect Kanonikal**:
  - Menambahkan rute pengalihan 301 untuk URL legacy (`/join-us`, `/promotion`, `/villa`, `/about-us`, `/contact-us`, `/term-condition`).

---

## [1.0.0] - 2026-10-10
### 🚀 Rilis Perdana (Initial Release)
- Arsitektur berbasis Laravel 12 dan PHP 8.4.
- Portal publik multi-brand: Ubu Villa, Buruj Villa, dan Ubu Glamping.
- Interactive search widget dengan Flatpickr dan Airbnb-style guests counter.
- Admin CMS lengkap dengan sistem otentikasi session custom, manajemen brand, properti, fasilitas, promosi, pengalaman, artikel, ulasan, halaman statis, navigasi, media, SEO, dan audit log.
- Dokumentasi teknis terstruktur dan test suite fitur dengan Pest PHP.

---

**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**  
*Lead Software Architect & Maintainer*
