# 🤝 Panduan Kontribusi (Contributing Guidelines)

Terima kasih atas minat dan apresiasi Anda terhadap proyek **Ubu Hospitality Platform & Multi-Brand Property Management CMS**!

Aplikasi ini dikembangkan dan dirancang oleh **Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)** untuk mendukung operasional portofolio villa dan resort di bawah naungan **PT Ubu Hospitality Indonesia**. Mengingat sistem ini berlisensi **Proprietary (All Rights Reserved)**, segala bentuk kontribusi berlangsung dengan ketentuan dan pedoman di bawah ini.

---

## 📌 Kebijakan Hak Cipta & Kontribusi

1. **Kepemilikan Hak Cipta**: Seluruh basis kode, arsitektur, dan aset sistem dilindungi hak cipta atas nama pemilik proyek.
2. **Penyerahan Kontribusi**: Dengan mengirimkan *Pull Request* atau kontribusi kode, Anda menyetujui bahwa kode tersebut merupakan karya orisinal Anda dan hak ciptanya diintegrasikan ke dalam proyek resmi ini tanpa klaim kepemilikan terpisah.
3. **Larangan Plagiarisme & Penghapusan Atribusi**: Dilarang keras menghapus watermark, nama pembuat, atau metadata lisensi yang tertanam di dalam aplikasi.

---

## 🛠️ Standar Pengembangan Kode (Code Standards)

Untuk menjaga kualitas sistem kelas enterprise, seluruh kontribusi wajib mematuhi standar teknis berikut:

### 1. Standar Bahasa & Framework
* **PHP**: Versi 8.4+ dengan *strict types*, *constructor property promotion*, dan *type hints* eksplisit pada method.
* **Framework**: Laravel 12.x mengikuti kaidah *The Laravel Way* (Artisan commands, Eloquent models, dan Resource routing).
* **Format Gaya Kode (Pint)**: Wajib lolos format PSR-12 menggunakan Laravel Pint:
  ```bash
  vendor/bin/pint --format agent
  ```

### 2. Arsitektur Kode
* **Pemisahan Tanggung Jawab**:
  * **Controllers**: Ramping dan terfokus pada penerimaan HTTP request dan pengembalian response/view.
  * **FormRequests**: Validasi input formulir dipusatkan pada file `FormRequest` khusus dengan pesan validasi berbahasa Indonesia.
  * **Services**: Logika bisnis kompleks (pemrosesan media, kalkulasi harga, navigasi, SEO) wajib berada di `app/Services/`.
* **Sistem Media & Gambar**:
  * Gunakan [`ImageUploadService`](file:///C:/xampp/htdocs/ubu-hospitality/app/Services/ImageUploadService.php) untuk mengunggah gambar.
  * Dilarang membuat dependensi baru yang mewajibkan `php artisan storage:link`.
  * Pastikan gambar diproses ke WebP, di-resize secara proporsional, dan file lama dihapus dari disk saat record diupdate/dihapus.

### 3. Pengujian Otomatis (Automated Tests)
* Setiap penambahan fitur baru atau perbaikan bug wajib disertai pengujian fitur menggunakan **Pest PHP**:
  ```bash
  # Menjalankan pengujian fitur yang relevan
  php artisan test --filter=NamaFiturTest --compact

  # Menjalankan seluruh test suite
  php artisan test --compact
  ```
* Pastikan seluruh 42+ automated tests lulus 100% tanpa ada kegagalan (*0 failures*).

### 4. Standar UI/UX Frontend
* Desain wajib responsif di semua ukuran layar (Mobile, Tablet, Laptop, dan Desktop).
* Ikuti palet warna resmi: **Teal** (`#0085a2`), **Gold** (`#f1c40f`), dan **Charcoal** (`#222222`). Hindari penggunaan warna coklat (*brown*) dan biru dongker (*navy*).
* Gunakan Bootstrap 5.3 + Bootstrap Icons + SweetAlert2. Dilarang menggunakan fungsi pop-up native browser seperti `alert()` atau `confirm()`.

---

## 🌿 Alur Kerja Git (Git Workflow)

1. **Fork & Kloning Repositori**:
   ```bash
   git clone https://github.com/ardhikaxx/ubu-hospitality.git
   cd ubu-hospitality
   ```

2. **Buat Branch Fitur Baru**:
   Gunakan format penamaan branch yang jelas:
   * `feat/nama-fitur` (untuk fitur baru)
   * `fix/nama-bug` (untuk perbaikan bug)
   * `perf/optimasi-performa` (untuk peningkatan performa)
   * `docs/pembaruan-panduan` (untuk perbaikan dokumentasi)

   ```bash
   git checkout -b feat/integrasi-widget-kalender
   ```

3. **Format Pesan Commit (Conventional Commits)**:
   Tulis pesan commit yang deskriptif dalam Bahasa Indonesia:
   * `feat: penambahan filter pencarian villa berdasarkan ketersediaan private pool`
   * `fix: perbaikan posisi drawer menu pada resolusi layar ponsel lipat`
   * `docs: pembaruan langkah instalasi di berkas README`

4. **Kirimkan Pull Request (PR)**:
   * Satu PR hanya berfokus pada satu tujuan fungsionalitas yang spesifik.
   * Sertakan ringkasan perubahan, alasan desain, dan bukti bahwa `php artisan test --compact` serta `vendor/bin/pint --format agent` telah lolos.
   * Maintainer akan meninjau kode Anda sebelum digabungkan ke branch utama (`main`).

---

## 🐞 Melaporkan Masalah & Bug

* Gunakan kanal **GitHub Issues** resmi untuk melaporkan bug aplikasi.
* Sertakan detail lingkungan pengembangan (versi OS, PHP, MySQL), langkah-langkah reproduksi bug, dan tangkapan layar jika relevan.
* Untuk pelaporan celah keamanan atau kerentanan data sensitif, **JANGAN** menggunakan issue publik, melainkan ikuti panduan pada [SECURITY.md](./SECURITY.md).

---

**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**  
*Lead Software Architect & Maintainer*
