# MemberPlus

MemberPlus adalah aplikasi web untuk mengelola program membership dan loyalitas pelanggan. Staf dapat mendaftarkan member, mencatat transaksi belanja, memberikan poin, dan menukarkan poin dengan reward melalui satu aplikasi.

## Latar belakang

Pengelolaan membership yang tersebar di catatan transaksi dan daftar pelanggan terpisah dapat menyulitkan operasional toko:

- Saldo dan riwayat poin sulit dilacak jika pencatatan transaksi dilakukan secara manual.
- Staf perlu mencocokkan data pembelian dengan member sebelum poin dapat diberikan.
- Member dan tingkat keanggotaannya sulit dipantau jika data tersimpan di beberapa tempat.
- Penukaran reward perlu mengurangi saldo poin dan memperbarui stok secara konsisten.
- Pemilik toko membutuhkan ringkasan transaksi, jumlah member, dan aktivitas poin.

MemberPlus menyatukan data member, tier, transaksi, poin, dan reward. Saat staf mencatat transaksi, sistem menghitung poin sesuai nilai belanja dan pengali tier. Saat reward ditukar, sistem memeriksa saldo poin dan ketersediaan stok.

## Fitur

- **Dashboard** — ringkasan member aktif, poin beredar, penjualan hari ini, aktivitas poin, transaksi terbaru, dan member teratas.
- **Member** — pendaftaran dan pembaruan data, pencarian berdasarkan nama, nomor telepon, kode, atau email, filter status, detail profil, saldo, dan riwayat poin.
- **Kasir** — pencarian member aktif dan pencatatan nilai belanja, nomor invoice, serta catatan transaksi.
- **Perhitungan poin** — poin diberikan berdasarkan nominal belanja dan pengali tier member.
- **Tier membership** — data awal menyediakan tier Bronze, Silver, dan Gold dengan pengali poin yang berbeda.
- **Katalog reward** — pengelolaan hadiah, biaya poin, status aktif, urutan tampilan, dan stok.
- **Penukaran poin** — penukaran reward dengan pemeriksaan saldo dan stok, serta pencatatan riwayat.
- **Riwayat transaksi** — daftar transaksi penjualan dan penukaran yang dapat ditelusuri.
- **Tampilan responsif** — halaman menyesuaikan ukuran layar desktop, tablet, dan ponsel.

## Alur penggunaan

1. Daftarkan pelanggan melalui halaman **Member**.
2. Pilih member tersebut saat mencatat belanja melalui halaman **Kasir**.
3. Member menerima poin sesuai nominal transaksi dan tier yang berlaku.
4. Pilih member pada halaman **Tukar reward** untuk melihat saldo dan menukar hadiah yang tersedia.

Member di aplikasi ini merupakan catatan membership yang dikelola staf. Saat ini belum ada login khusus untuk pelanggan maupun staf, dan transaksi kasir masih dicatat dari halaman MemberPlus. Integrasi otomatis dengan mesin kasir atau sistem POS belum tersedia.

## Teknologi

- PHP 8.3 atau lebih baru
- Laravel 13
- Blade dan Tailwind CSS
- SQLite sebagai database bawaan; MySQL juga dapat digunakan
- Composer
- Node.js dan npm tersedia untuk pengembangan aset frontend Laravel

## Menjalankan secara lokal

Pastikan PHP, Composer, dan SQLite tersedia. Dari folder proyek:

```bash
composer install
```

Salin `.env.example` hanya jika file `.env` belum tersedia. Di PowerShell:

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
```

Di macOS atau Linux:

```bash
test -f .env || cp .env.example .env
```

Jika ini instalasi baru dan `APP_KEY` masih kosong, buat application key. Jangan mengganti `.env` atau key yang sudah digunakan. Jalankan migrasi dan data contoh, lalu nyalakan server:

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser. `.env.example` menggunakan SQLite. Jika database SQLite belum ada, buat file `database/database.sqlite` sebelum menjalankan migrasi.

Seeder menambahkan tier Bronze, Silver, Gold, beberapa reward, serta dua member contoh:

- Rina Wijaya — saldo awal 80 poin.
- Budi Santoso — saldo awal 0 poin.

Data ini hanya untuk demonstrasi dan bukan akun login.

## Konfigurasi database

Untuk memakai MySQL, ubah pengaturan database di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=memberplus
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `memberplus` terlebih dahulu, lalu jalankan:

```bash
php artisan migrate --seed
```

## Perintah pengembangan

```bash
php artisan serve       # Jalankan server aplikasi
php artisan migrate     # Jalankan migrasi database
php artisan db:seed     # Tambahkan data contoh
php artisan test        # Jalankan test suite
```

## Catatan penggunaan

- Aplikasi saat ini tidak memiliki autentikasi atau pembatasan peran. Semua halaman operasional dapat diakses tanpa login.
- Gunakan data contoh untuk demonstrasi lokal. Tambahkan autentikasi dan otorisasi sebelum aplikasi digunakan untuk operasional nyata.
- Jangan menyimpan kredensial produksi atau informasi rahasia ke repository.

---

MemberPlus · Kelola membership, transaksi, dan reward pelanggan dalam satu aplikasi.
