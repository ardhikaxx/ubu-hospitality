# 💬 Dukungan & Bantuan Teknis (Support)

Terima kasih telah menggunakan dan mengembangkan **Ubu Hospitality Platform & Multi-Brand Property Management CMS**.

Jika Anda memerlukan bantuan teknis, konsultasi arsitektur perhotelan, atau berminat melakukan kustomisasi sistem untuk pengelolaan villa dan resort Anda, silakan hubungi kanal komunikasi resmi berikut:

---

## 📬 Kanal Komunikasi Resmi

* **Pemilik & Pengembang Utama**: **Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**
* **Email Resmi**: `ardhikayanuar58@gmail.com`
* **WhatsApp Dukungan Teknis**: `+62 823-2000-3297` (atau via kontak langsung pengembang)
* **GitHub Issues**: [https://github.com/ardhikaxx/ubu-hospitality/issues](https://github.com/ardhikaxx/ubu-hospitality/issues)
* **Repositori Resmi**: [https://github.com/ardhikaxx/ubu-hospitality](https://github.com/ardhikaxx/ubu-hospitality)

---

## 📚 Sumber Dokumentasi Mandiri

Sebelum mengajukan pertanyaan teknis, kami sangat menyarankan untuk membaca dokumen pendukung yang telah disediakan:

1. [`README.md`](./README.md) — Panduan instalasi cepat, fitur sistem, dan akun demo.
2. [`CHANGELOG.md`](./CHANGELOG.md) — Riwayat pembaruan dan rilis fitur.
3. [`SECURITY.md`](./SECURITY.md) — Arsitektur keamanan dan pelaporan celah.
4. [`CONTRIBUTING.md`](./CONTRIBUTING.md) — Standar penulisan kode dan alur kerja Git.
5. [`CODE_OF_CONDUCT.md`](./CODE_OF_CONDUCT.md) — Pedoman etika dan perilaku komunitas.
6. [`CITATION.md`](./CITATION.md) — Format sitasi akademik untuk penelitian/jurnal.

---

## 🧭 Panduan Sebelum Mengajukan Pertanyaan

Untuk mempercepat penanganan kendala yang Anda hadapi, mohon pastikan hal berikut:

1. **Periksa Kebutuhan Lingkungan**: Pastikan Anda menggunakan PHP 8.4+, Composer 2.x, dan MySQL 8.0+.
2. **Database Bersih**: Untuk lingkungan lokal/development baru, gunakan perintah:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Peringatan: Jangan pernah menjalankan `migrate:fresh` di lingkungan server produksi).*
3. **Pemeriksaan Log Sistem**: Buka berkas log di `storage/logs/laravel.log` jika Anda menemui kendala error 500.
4. **Sertakan Informasi Lengkap**: Saat mengajukan pertanyaan atau membuat issue, sertakan:
   * Tangkapan layar (*screenshot*) pesan error.
   * Langkah-langkah kronologis untuk mereproduksi masalah.
   * Versi sistem operasi dan lingkungan server yang digunakan.

---

## 🛠️ Layanan Kustomisasi & Implementasi Enterprise

Apakah Anda membutuhkan implementasi sistem khusus untuk resort, rantai villa (*villa chain*), atau hotel butik Anda? Layanan profesional berikut tersedia melalui kontak resmi:

* **Instalasi & Deployment Produksi**: Pengaturan server Linux (Ubuntu/Debian), konfigurasi Nginx/Apache dengan SSL/HTTPS, optimasi OPcache, dan supervisi queue worker.
* **Integrasi Payment Gateway**: Integrasi pembayaran otomatis dengan Midtrans, Xendit, DOKU, atau BCA Virtual Account.
* **Integrasi Channel Manager**: Sinkronisasi ketersediaan kamar dan tarif secara otomatis dengan OTA global (Airbnb, Booking.com, Agoda, Traveloka) via API iCal / REST API.
* **Pengembangan Modul Kustom**: Modul POS Restoran in-villa, manajemen housekeeping & inventaris linen, atau modul multi-cabang regional.

---

## 💖 Dukungan & Donasi

Jika proyek **Ubu Hospitality Platform** ini bermanfaat bagi Anda, telah membantu bisnis perhotelan Anda, atau menghemat ratusan jam waktu pengembangan Anda, Anda dapat menunjukkan apresiasi dengan memberikan traktiran kopi (donasi sukarela) melalui pemindaian kode **QRIS** di bawah ini:

<p align="center">
  <img src="./qris.png" alt="QRIS Donasi" width="300"/>
</p>

> Donasi sepenuhnya bersifat sukarela dan tidak mengikat. Seluruh fungsionalitas aplikasi tetap dapat digunakan secara utuh tanpa kewajiban donasi.

---

**Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)**  
*Lead Software Architect & Maintainer*
