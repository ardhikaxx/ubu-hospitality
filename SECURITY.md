# 🛡️ Kebijakan Keamanan (Security Policy)

Keamanan sistem informasi, integritas data operasional villa, dan kerahasiaan data pribadi tamu serta mitra properti adalah prioritas tertinggi dalam pengembangan **Ubu Hospitality Platform & Multi-Brand Property Management CMS**.

Sistem ini dibangun dengan mematuhi prinsip pengembangan perangkat lunak aman (*secure by design*), standar enkripsi modern, dan kepatuhan terhadap **Undang-Undang Perlindungan Data Pribadi (UU PDP No. 27 Tahun 2022)**.

---

## 📦 Versi yang Didukung

Pembaruan keamanan (*security patches*) dan pemantauan kerentanan aktif diberikan untuk versi berikut:

| Versi Sistem | Status Pemeliharaan Keamanan |
| :--- | :--- |
| **v1.3.x** | ✅ Didukung Penuh (*Active Security Maintenance*) |
| **v1.2.x** | ✅ Didukung (Critical Patches Only) |
| < 1.2.0 | ❌ Tidak Didukung (Disarankan Segera Upgrade) |

---

## 🔒 Lapisan Keamanan Bawaan (Built-in Security Layers)

### 1. Autentikasi & Manajemen Sesi yang Aman
* **Session Regeneration**: Sesi secara otomatis diperbarui (*regenerated*) setelah login berhasil untuk mencegah serangan *Session Fixation*.
* **Otentikasi Sandi Kuat**: Kata sandi dienkripsi menggunakan algoritma *Bcrypt* dengan *work factor* standar industri dan tidak pernah disimpan atau ditampilkan dalam bentuk teks polos (*plaintext*).
* **Logout Aman**: Proses logout wajib dilakukan melalui HTTP POST yang dilindungi token CSRF serta memvalidasi dan menghancurkan seluruh sesi aktif.

### 2. Perlindungan dari Serangan Web Standar OWASP
* **Perlindungan CSRF (Cross-Site Request Forgery)**: Seluruh formulir pengiriman data publik (pengajuan kemitraan, filter, pencarian) dan form admin dilindungi token CSRF terverifikasi.
* **Perlindungan SQL Injection**: Menggunakan *PDO Prepared Statements* yang terisolasi melalui Eloquent ORM. Tidak ada query string mentah yang dieksekusi langsung dari input pengguna.
* **Perlindungan XSS (Cross-Site Scripting)**: Seluruh variabel yang dirender pada Blade template otomatis disanitasi dan di-escape (`{{ $variable }}`). Input berbahaya pada form deskripsi properti atau artikel blog dibersihkan secara ketat.

### 3. Keamanan Sistem Upload & Streaming Media
* **Validasi Ekstensi & MIME Type**: Hanya berkas gambar valid (`jpg`, `jpeg`, `png`, `webp`, `svg`) yang diizinkan untuk diunggah dengan batasan ukuran file yang ketat.
* **Sanitasi Path Traversal**: Rute streaming berkas publik `/uploads/{folder}/{filename}` dan `/storage/{path}` memvalidasi nama folder dan file menggunakan regex ketat `^[a-zA-Z0-9_-]+$` dan otomatis menolak upaya *directory traversal* (seperti `../`, `..\\`, atau karakter null-byte).
* **Pembersihan Metadata**: Konversi gambar otomatis ke format WebP memangkas metadata tersembunyi (EXIF) yang berpotensi memuat informasi sensitif lokasi pengambilan foto kamera.

### 4. Audit Trail & Pencatatan Aktivitas (Logging)
* Setiap tindakan krusial di Admin CMS (login, logout, pembuatan properti, pengubahan tarif, penghapusan media, pengubahan status kemitraan, perubahan pengaturan sistem) dicatat secara otomatis dalam tabel `audit_logs` lengkap dengan IP address, *User-Agent*, dan waktu kejadian.

### 5. Perlindungan Data Prospek Kemitraan & Tamu
* Data kontak dan rincian properti yang dikirimkan pemilik villa melalui formulir kemitraan dienkripsi dan hanya dapat diakses oleh staf berwenang melalui Admin CMS yang terotentikasi.

---

## 🚨 Prosedur Pelaporan Celah Keamanan (Responsible Disclosure)

Jika Anda menemukan kelemahan, celah keamanan, atau potensi kerentanan (*security vulnerability*) dalam sistem ini:

> [!CAUTION]
> **JANGAN PERNAH** membuat laporan terbuka pada GitHub Issues publik atau media sosial demi melindungi integritas sistem dan privasi data pengguna.

Silakan kirimkan laporan celah keamanan secara privat dan bertanggung jawab melalui kanal resmi pengembang:

* **Email Resmi Penanggung Jawab Keamanan**: `ardhikayanuar58@gmail.com`
* **Subjek Email**: `[SECURITY VULNERABILITY] - Ubu Hospitality Platform`

### Format Informasi yang Diharapkan:
1. **Jenis Kerentanan**: (misal: IDOR, SQL Injection, XSS, CSRF, Path Traversal, dll.).
2. **Lokasi / URL Endpoint**: Rute atau controller yang terpengaruh.
3. **Langkah-langkah Reproduksi (PoC)**: Langkah detail atau payload yang digunakan untuk mereproduksi masalah.
4. **Analisis Dampak**: Estimasi dampak risiko terhadap operasional sistem atau data tamu.

### Komitmen Respon Kami:
* Kami akan mengirimkan konfirmasi penerimaan laporan dalam kurun waktu **1x24 jam**.
* Pembaruan status analisis dan perbaikan (*patch*) akan dirilis secara prioritas tinggi dalam waktu **48-72 jam**.
* Nama pelapor yang beretika baik akan dicantumkan dengan hormat pada catatan rilis jika berkenan.

---

**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**  
*Lead Software Architect & Maintainer*
