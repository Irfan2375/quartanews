# Cara Menjalankan QuartaNews (Setelah Clone dari GitHub)

Panduan ini untuk kamu yang sudah meng-clone repo ini ke komputer lokal
(misal via Laragon di Windows). Ikuti urutan di bawah.

## 1. Prasyarat (Windows + Laragon)

Pastikan sudah terpasang:

- **Laragon** (bundle PHP + MySQL + Apache) — https://laragon.org
- **PHP 8.3+** (Laragon menyediakan; project ini diuji dengan PHP 8.4)
- **Composer** (sudah include di Laragon)
- **MySQL** aktif di Laragon (tombol "Database" → Start)

> Project ini memakai **MySQL**, bukan SQLite. Pastikan service MySQL jalan
> sebelum `php artisan migrate`.

## 2. Letakkan project

Taruh folder project di dalam folder `www` Laragon, misal:

```
C:\laragon\www\quartanews\
```

Lalu buat virtual host (atau cukup pakai `php artisan serve` — lihat bawah).

Cara termudah di Laragon: klik kanan ikon Laragon → **www** → pilih folder
`quartanews`, maka otomatis tersedia di `http://quartanews.test/`
(Laragon membuat vhost + entry `hosts` sendiri).

## 3. Install dependency

Buka terminal (Laragon Terminal / PowerShell) di dalam folder project:

```sh
cd C:\laragon\www\quartanews
composer install
```

## 4. Setup environment

Salin file `.env.example` menjadi `.env` (kalau belum ada), lalu sesuaikan
bagian database agar menunjuk ke MySQL Laragon:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quartanews
DB_USERNAME=root
DB_PASSWORD=
```

> Default MySQL di Laragon: user `root` **tanpa password**. Kalau kamu sudah
> pasang password, sesuaikan `DB_PASSWORD`.

Lalu generate app key:

```sh
php artisan key:generate
```

## 5. Buat database & isi data

Masuk ke MySQL (phpMyAdmin Laragon di `http://localhost/phpmyadmin`) dan buat
database baru bernama **`quartanews`** (collation `utf8mb4_unicode_ci`).

Atau lewat terminal:

```sh
mysql -u root -e "CREATE DATABASE quartanews CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Lalu jalankan migrasi + seeder:

```sh
php artisan migrate --seed
```

Perintah di atas akan:
- membuat semua tabel (users, articles, sessions, cache, jobs, dst)
- membuat **user admin default** (lihat bawah)
- mengisi **20 artikel contoh** berbahasa Indonesia

## 6. Storage (untuk foto upload)

Jalankan sekali agar folder upload bisa diakses publik:

```sh
php artisan storage:link
```

## 7. Jalankan

### Opsi A — via Laragon (recommended)
Pastikan Apache + MySQL "Start" di Laragon, lalu buka:
```
http://quartanews.test/
```

### Opsi B — via built-in server
```sh
php artisan serve
```
Lalu buka `http://127.0.0.1:8000/`.

## 8. Login Admin & User Default

Setelah `php artisan migrate --seed`, sudah tersedia satu user admin:

```
URL      : http://quartanews.test/admin/articles
           (atau http://quartanews.test/login)
Email    : admin@quartanews.test
Password : password123
```

> **Penting:** Ganti password ini di Production! Jangan pakai credential default
> di server live. Bisa diubah lewat phpMyAdmin (tabel `users`, kolom `password`
> di-hash dengan bcrypt) atau buat seeder sendiri.

Logout: klik "Logout" di pojok kanan atas admin, atau buka `/logout`.

## 9. Troubleshooting

- **Error "could not find driver" (SQLite/MySQL)** → extensi `pdo_mysql` belum
  aktif. Buka `php.ini` Laragon, pastikan `extension=pdo_mysql` tidak dikomentari,
  lalu **restart Apache**.
- **Beranda 500 setelah ubah `.env`** → restart Apache (web server membaca
  `.env` hanya saat startup).
- **Login gagal padahal benar** → clear cookie browser untuk `quartanews.test`
  (atau buka incognito), lalu login ulang.
- **Foto tidak muncul** → pastikan sudah jalan `php artisan storage:link`.

## 10. Struktur credentials (ringkas)

| Item            | Nilai                    |
|-----------------|--------------------------|
| DB connection   | mysql                    |
| DB host/port    | 127.0.0.1 : 3306        |
| DB name         | quartanews              |
| DB user         | root                     |
| DB password     | (kosong)                 |
| Admin email     | admin@quartanews.test   |
| Admin password  | password123              |
