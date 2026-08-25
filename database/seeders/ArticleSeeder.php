<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    private function make(array $a): void
    {
        Article::create([
            'title' => $a['title'],
            'slug' => Str::slug($a['title']),
            'category' => $a['category'],
            'author' => $a['author'],
            'excerpt' => $a['excerpt'],
            'body' => $a['body'],
            'photo1' => $a['photo1'] ?? null,
            'photo2' => $a['photo2'] ?? null,
            'photo3' => $a['photo3'] ?? null,
            'is_featured' => $a['is_featured'] ?? false,
            'is_lead' => $a['is_lead'] ?? false,
            'published_at' => $a['published_at'] ?? now(),
        ]);
    }

    private function dummyImage(string $name): string
    {
        $content = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $path = 'articles/'.$name.'-'.Str::random(12).'.png';
        Storage::disk('public')->put($path, $content);

        return $path;
    }

    public function run(): void
    {
        // body sekarang PLAIN TEXT — enter 2x = paragraf baru (gak perlu HTML)

        // LEAD (dikasih 2 foto inside biar demo kelihatan)
        $p1 = $this->dummyImage('lead1');
        $p2 = $this->dummyImage('lead2');
        $this->make([
            'title' => 'Kota Menata Ulang Ruang Publik: Mengapa Trotoar Jadi Arena Politik Baru',
            'category' => 'budaya',
            'author' => 'Dimas Purnomo',
            'excerpt' => 'Di tengah melambatnya pembangunan skala besar, sejumlah pemerintah daerah beralih pada intervensi kecil yang menyentuh hari-hari warga — dari halte hingga titik penyeberangan.',
            'body' => "Di tengah melambatnya pembangunan skala besar, sejumlah pemerintah daerah beralih pada intervensi kecil yang menyentuh hari-hari warga — dari halte hingga titik penyeberangan.

Pakar tata kota menilai pergeseran ini bukan sekadar estetika, melainkan pernyataan politik tentang siapa yang diprioritaskan di ruang publik.

Survei lapangan menunjukkan warga merasakan perubahan paling nyata justru pada hal terkecil: lampu jalan yang kembali menyala, atau zebra cross yang akhirnya bisa dilewati tanpa was-was.

Perubahan kecil seperti ini kerap luput dari berita utama, padahal ia yang paling dekat dengan kulit kita sehari-hari.",
            'photo1' => $p1,
            'photo2' => $p2,
            'is_lead' => true,
            'is_featured' => true,
            'published_at' => now()->subHours(2),
        ]);

        // BERITA TERATAS (rail)
        $this->make([
            'title' => 'Rupiah Bertahan di Tengah Tekanan Ekspor',
            'category' => 'ekonomi',
            'author' => 'Tim Ekonomi',
            'excerpt' => 'Bank sentral menyatakan cadangan devisa masih dalam level aman meski ekspor melambat.',
            'body' => "Bank sentral menyatakan cadangan devisa masih dalam level aman meski ekspor melambat.

Analis menilai stabilitas ini ditopang oleh aliran modal masuk yang konsisten.",
            'is_featured' => true,
            'published_at' => now()->subMinutes(12),
        ]);
        $this->make([
            'title' => 'Startup Lokal Melirik Pasar Industri, Bukan Konsumen',
            'category' => 'teknologi',
            'author' => 'Yusuf N.',
            'excerpt' => 'Setelah bertahun-tahun berburu pengguna, banyak startup beralih melayani pabrik dan logistik.',
            'body' => "Setelah bertahun-tahun berburu pengguna, banyak startup beralih melayani pabrik dan logistik.

Pendekatan ini dianggap lebih tahan krisis karena kontrak berjangka panjang.",
            'is_featured' => true,
            'published_at' => now()->subMinutes(41),
        ]);
        $this->make([
            'title' => 'Parlemen Bahas Ulang Aturan Data Warga',
            'category' => 'politik',
            'author' => 'Tim Politik',
            'excerpt' => 'Pembahasan mencakup batas penyimpanan dan hak warga atas datanya sendiri.',
            'body' => "Pembahasan mencakup batas penyimpanan dan hak warga atas datanya sendiri.

Salah satu fraksi mendorong kode etik wajib bagi pengelola data publik.",
            'is_featured' => true,
            'published_at' => now()->subHours(1),
        ]);
        $this->make([
            'title' => 'Festival Dokumenter Kembali Hadir Secara Luring',
            'category' => 'budaya',
            'author' => 'Laras T.',
            'excerpt' => 'Setelah dua tahun hibrida, rangkaian pemutaran kembali digelar di ruang terbuka.',
            'body' => "Setelah dua tahun hibrida, rangkaian pemutaran kembali digelar di ruang terbuka.

Kurasi tahun ini menyoroti suara daerah yang jarang terdengar arus utama.",
            'is_featured' => true,
            'published_at' => now()->subHours(2),
        ]);

        // TERBARU
        $this->make([
            'title' => 'Peneliti Temukan Cara Baru Mengukur Kualitas Udara Per Blok',
            'category' => 'sains',
            'author' => 'Rina S.',
            'excerpt' => 'Sensor murah dan terbuka memungkinkan warga memetakan polusi di lingkungan sendiri.',
            'body' => "Sensor murah dan terbuka memungkinkan warga memetakan polusi di lingkungan sendiri.

Data partisipatif ini diharapkan memicu kebijakan lingkungan yang lebih tepat sasaran.",
            'published_at' => now()->subHours(3),
        ]);
        $this->make([
            'title' => 'Liga Domestik Cetak Rekor Penonton Musim Ini',
            'category' => 'olahraga',
            'author' => 'Bagus A.',
            'excerpt' => 'Kenaikan jumlah penonton perempuan jadi sorotan utama para pengamat.',
            'body' => "Kenaikan jumlah penonton perempuan jadi sorotan utama para pengamat.

Klub menyebut atmosfer stadion berubah drastis sejak program kampanye inklusif diluncurkan.",
            'published_at' => now()->subHours(4),
        ]);
        $this->make([
            'title' => 'Bahasa Daerah Mulai Masuk Model Kecerdasan Buatan Lokal',
            'category' => 'teknologi',
            'author' => 'Yusuf N.',
            'excerpt' => 'Upaya menjaga keberagaman linguistik di tengah dominasi bahasa mayoritas.',
            'body' => "Upaya menjaga keberagaman linguistik di tengah dominasi bahasa mayoritas.

Komunitas menyumbangkan korpus teks agar model lebih peka pada konteks lokal.",
            'published_at' => now()->subHours(5),
        ]);

        // FEATURE TEKNOLOGI
        $this->make([
            'title' => 'Ketika Kode Tidak Lagi Ditulis, Melainkan Diajukan',
            'category' => 'teknologi',
            'author' => 'Hendra W.',
            'excerpt' => 'Pergeseran dari mengetik baris kode ke merangkai maksud memaksa kita memikirkan ulang apa arti "ahli".',
            'body' => "Pergeseran dari mengetik baris kode ke merangkai maksud memaksa kita memikirkan ulang apa arti \"ahli\" di dunia perangkat lunak.

Yang berharga bukan lagi hafalan sintaks, melainkan kemampuan merumuskan masalah dengan presisi.",
            'is_featured' => true,
            'published_at' => now()->subHours(6),
        ]);
        $this->make([
            'title' => 'Perangkat Tepian Mulai Ambil Alih Komputasi Awan',
            'category' => 'teknologi',
            'author' => 'Hendra W.',
            'excerpt' => 'Pemrosesan di dekat sumber data diprediksi mengurangi latensi dan biaya.',
            'body' => "Pemrosesan di dekat sumber data diprediksi mengurangi latensi dan biaya.

Industri manufaktur jadi pionir adopsi karena butuh respons instan di lantai pabrik.",
            'published_at' => now()->subHours(7),
        ]);
        $this->make([
            'title' => 'Kata Sandi Perlahan Menyerah pada Kunci Fisik',
            'category' => 'teknologi',
            'author' => 'Yusuf N.',
            'excerpt' => 'Standar keamanan baru mulai menggeser kata sandi sebagai benteng utama.',
            'body' => "Standar keamanan baru mulai menggeser kata sandi sebagai benteng utama.

Kunci fisik dianggap lebih kebal terhadap serangan phishing.",
            'published_at' => now()->subHours(8),
        ]);
        $this->make([
            'title' => 'Sekolah Menyenangkan Ulang Kurikulum Komputer',
            'category' => 'teknologi',
            'author' => 'Rina S.',
            'excerpt' => 'Fokus bergeser dari aplikasi perkantoran ke berpikir komputasional.',
            'body' => "Fokus bergeser dari aplikasi perkantoran ke berpikir komputasional.

Guru melaporkan murid lebih antusias saat belajar lewat proyek nyata.",
            'published_at' => now()->subHours(9),
        ]);

        // OPINI
        $this->make([
            'title' => 'Kota yang Layak Adalah Kota yang Memberi Ruang untuk Melambat',
            'category' => 'opini',
            'author' => 'Siti Aisyah',
            'excerpt' => 'Kita sering salah mengira bahwa kota modern berarti kota yang cepat.',
            'body' => "Kita sering salah mengira bahwa kota modern berarti kota yang cepat.

Padahal kota yang layak justru yang memberi ruang untuk melambat, berhenti sejenak, dan bertemu tetangga.",
            'published_at' => now()->subHours(10),
        ]);
        $this->make([
            'title' => 'Data Warga Bukan Aset Negara untuk Dikumpulkan',
            'category' => 'opini',
            'author' => 'Reza Anwar',
            'excerpt' => 'Data warga ialah amanat yang wajib dikembalikan dalam bentuk pelayanan.',
            'body' => "Data warga bukan aset negara untuk dikumpulkan, melainkan amanat yang wajib dikembalikan dalam bentuk pelayanan yang lebih baik.

Tanpa akuntabilitas, setiap baris data adalah utang yang belum dibayar.",
            'is_featured' => true,
            'published_at' => now()->subHours(11),
        ]);

        // tambahan acak agar grid terasa hidup
        Article::factory()->count(6)->create([
            'published_at' => now()->subDays(rand(1, 14)),
        ]);
    }
}
