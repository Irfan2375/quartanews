# QuartaNews — Laravel 13 Portfolio Project

Portal berita independen (prototype editorial) yang dibangun di atas Laravel 13
sebagai bahan portofolio. Nama disesuaikan dengan domain `quartadocx` → "QuartaNews".

## Status: PRODUCTION-READY (CRUD + upload foto + admin panel)
Terakhir update: 26 Agustus 2026

## Stack
- Laravel 13.27.0 (PHP 8.4.24 via Laragon)
- **Database: MySQL** (`quartanews` di Laragon MySQL 8.0.30, root no password)
  - Dipindah dari SQLite atas permintaan user (biar "sql biasa" + kelola di phpMyAdmin)
- Frontend: Blade + Newsreader (serif headline) + Inter (body) — desain editorial anti-AI-slop
- Storage: `storage/app/public/articles` + symlink `public/storage` (upload foto)

## Cara jalanin
1. Laragon sudah jalan (Apache + MySQL).
2. Buka http://quartanews.test/ (beranda) — HTTP 200.
3. Admin: http://quartanews.test/admin/articles
   - Login: admin@quartanews.test / password123
   - Session aktif → /login otomatis redirect ke beranda (itu normal, bukan error).
     Untuk logout: klik Logout di admin, atau buka /logout.

## Fitur
- [x] Beranda: lead story + rail "Berita Teratas" + grid "Terbaru" + feature Teknologi + Opini
- [x] Kategori: /kategori/{slug} (7 rubrik: politik, ekonomi, teknologi, budaya, olahraga, sains, opini)
- [x] Artikel detail: /artikel/{slug} + "Baca Juga"
- [x] **Admin CRUD**: list (dengan thumbnail + badge status), create, edit, delete
- [x] **Upload foto**: thumbnail (hero) + maks 3 foto inside (photo1/2/3) tiap artikel
- [x] **Posisi foto custom**: dropdown "Taruh setelah paragraf ke-#" per foto (1-10),
      kosongkan = otomatis selang-seling tiap 2 paragraf. Tidak perlu rich editor/Word-style.
- [x] **Isi artikel plain text**: cukup ngetik, enter 2x = paragraf baru (otomatis <p> + escape, aman dari HTML injection)
- [x] Toggle tema terang/gelap + kepadatan (di beranda, simpan di localStorage)
- [x] Responsif + respects prefers-reduced-motion + aksesibilitas dasar

## Struktur file penting
- app/Models/Article.php — model + scope (published, lead, category) + accessor thumbnail_url
- app/Http/Controllers/ArticleController.php — beranda/kategori/show (public)
- app/Http/Controllers/AdminArticleController.php — CRUD + handleUpload + deleteOldThumbnail
- app/Http/Controllers/AuthController.php — login/logout (session Laravel)
- database/migrations/2026_08_26_000000_create_articles_table.php — struktur artikel
- database/migrations/2026_08_26_000001_add_thumbnail_to_articles_table.php — kolom foto
- database/seeders/ArticleSeeder.php — 20 artikel sampel (konten Indonesia)
- resources/views/layouts/app.blade.php — layout beranda (masthead, nav, footer, toggle)
- resources/views/articles/{index,category,show}.blade.php — halaman publik
- resources/views/articles/partials/thumb.blade.php — render foto atau placeholder
- resources/views/admin/{login, articles/index, articles/form}.blade.php — admin panel

## Catatan debugging (lessons learned)
- Edit .env (DB, APP_URL) wajib **restart Apache** (mod_php baca php.ini/.env cuma pas startup).
- Controller Laravel 13 extends `Illuminate\Routing\Controller` (bukan base App yang kosong)
  supaya `$this->middleware()` & method controller jalan.
- Validasi: pakai `request()->validate()` (helper global), bukan `$this->validate()` (butuh trait).
- CSRF: di browser asli cookie dikelola otomatis (aman). Di curl butuh cookie jar + token sama.
- `optional($article->published_at)` SALAH saat $article null → pakai `optional($article)->published_at`.

## Todo selanjutnya (opsional, belum diminta)
- [ ] Halaman About / Profil Irfan (ini portofolio → pasang identitas)
- [ ] Search + pagination yang lebih proper di kategori
- [ ] Resize otomatis pakai Intervention Image (saat ini original disimpan)
- [ ] Admin: filter by kategori/status di list
- [ ] Seed user admin lewat seeder (bukan manual tinker)
