# QuartaNews

Portal berita independen berbasis **Laravel 13**, dibuat sebagai bahan portofolio.
Nama diambil dari domain `quartadocx` → "QuartaNews".

## Apa itu QuartaNews?

QuartaNews adalah sebuah **website berita sederhana namun rapi** bergaya editorial
(koran), bukan template SaaS generik. Tujuannya sebagai demonstrasi kemampuan
pengembangan web (Laravel + Blade + MySQL) sekaligus tempat menampilkan tulisan.

Fitur utama:

- **Beranda editorial** — lead story (berita utama) + rail "Berita Teratas" + grid
  "Terbaru" + fitur Teknologi + kolom Opini.
- **7 rubrik** — politik, ekonomi, teknologi, budaya, olahraga, sains, opini.
- **Artikel detail** — hero foto + foto di dalam tulisan + "Baca Juga".
- **Admin panel** — login, kelola artikel (list / create / edit / delete).
- **Upload foto** — thumbnail (foto utama) + maksimal 3 foto di dalam artikel,
  dengan **penempatan posisi bebas** (taruh setelah paragraf ke-berapa).
- **Tulis artikel tanpa HTML** — cukup ngetik seperti catatan, enter 2× = paragraf baru.
- Tampilan terang/gelap + responsif.

## Teknologi

| Komponen | Detail |
|----------|--------|
| Framework | Laravel 13 (PHP 8.3+) |
| Bahasa | PHP 8.4 (di Laragon) |
| Database | MySQL (Laragon MySQL 8.0) |
| Frontend | Blade + Google Fonts (Newsreader serif + Inter) |
| Storage | `storage/app/public` + symlink `public/storage` |
| Auth | Session Laravel (login admin) |

## Struktur singkat

```
app/Models/Article.php                 # model artikel + accessor foto + bodyHtml()
app/Http/Controllers/ArticleController.php     # beranda / kategori / detail (publik)
app/Http/Controllers/AdminArticleController.php # CRUD admin + upload foto
app/Http/Controllers/AuthController.php         # login / logout
database/seeders/                      # UserSeeder + ArticleSeeder (data contoh)
resources/views/                       # layouts, halaman publik, admin, partials
```

## Default login admin

Lihat file `CLONE.md` untuk credentials default dan cara menjalankan project
setelah di-clone dari GitHub.

## Catatan

- Desain sengaja dibuat "anti AI-slop": paper hangat + tinta hitam + satu aksen merah,
  font serif untuk headline, tanpa gradient/glassmorphism.
- Semua konten contoh berbahasa Indonesia.
