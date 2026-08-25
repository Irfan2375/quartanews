<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $article ? 'Edit' : 'Tulis' }} Artikel — QuartaNews Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Newsreader:wght@700&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;}
  body{margin:0;font-family:'Inter',system-ui,sans-serif;background:#faf8f3;color:#1a1714;}
  .wrap{max-width:760px;margin:0 auto;padding:24px;}
  header{display:flex;justify-content:space-between;align-items:center;border-bottom:3px double #1a1714;padding-bottom:14px;margin-bottom:22px;}
  .brand{font-family:'Newsreader',serif;font-weight:700;font-size:28px;}
  .brand .q{color:#b4231c;}
  nav a{color:#443d35;font-weight:600;font-size:13.5px;text-decoration:none;margin-left:18px;}
  nav a:hover{color:#b4231c;}
  label{display:block;font-size:13px;font-weight:600;color:#443d35;margin:16px 0 6px;}
  input,select,textarea{width:100%;padding:11px 13px;border:1px solid #e3ddd0;border-radius:9px;font:inherit;font-size:14px;background:#fff;color:#1a1714;}
  textarea{min-height:230px;resize:vertical;line-height:1.6;}
  input:focus,select:focus,textarea:focus{outline:none;border-color:#b4231c;background:#fff;}
  .row2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
  .checks{display:flex;gap:20px;margin:18px 0;flex-wrap:wrap;}
  .checks label{margin:0;display:flex;align-items:center;gap:8px;font-weight:500;color:#1a1714;font-size:14px;}
  .checks input{width:auto;}
  .err{background:#f4e4e1;color:#931b15;border:1px solid #e7bdb8;padding:9px 12px;border-radius:8px;font-size:13px;margin-bottom:6px;}
  .actions{display:flex;gap:12px;margin-top:24px;}
  .btn{padding:12px 20px;border-radius:9px;font:inherit;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block;border:0;}
  .btn-save{background:#b4231c;color:#fff;}
  .btn-save:hover{background:#931b15;}
  .btn-cancel{background:#f1ede4;color:#443d35;}
  .hint{font-size:12px;color:#7a7165;margin-top:4px;}
</style>
</head>
<body>
<div class="wrap">
  <header>
    <div class="brand"><span class="q">Q</span>uartaNews <span style="font-size:14px;color:#7a7165;font-family:'Inter';font-weight:500;">/ {{ $article ? 'Edit' : 'Tulis Baru' }}</span></div>
    <nav>
      <a href="{{ route('admin.articles.index') }}">← Daftar</a>
      <a href="{{ route('home') }}">Beranda</a>
    </nav>
  </header>

  @if($errors->any())
    @foreach($errors->all() as $e)
      <div class="err">{{ $e }}</div>
    @endforeach
  @endif

  <form method="POST" action="{{ $article ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    @if($article) @method('PUT') @endif

    <label for="title">Judul</label>
    <input id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required>

    <div class="row2">
      <div>
        <label for="category">Rubrik</label>
        <select id="category" name="category" required>
          @foreach(\App\Http\Controllers\ArticleController::CATEGORIES as $slug => $label)
            <option value="{{ $slug }}" {{ old('category', $article->category ?? '') === $slug ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="author">Penulis</label>
        <input id="author" name="author" value="{{ old('author', $article->author ?? '') }}" required>
      </div>
    </div>

    <label for="excerpt">Ringkasan (excerpt)</label>
    <textarea id="excerpt" name="excerpt" style="min-height:90px;">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
    <p class="hint">Maksimal 500 karakter. Tampil di kartu berita & meta.</p>

    <label for="thumbnail">Foto Utama (thumbnail)</label>
    <input id="thumbnail" type="file" name="thumbnail" accept="image/*">
    <p class="hint">Format JPG/PNG/WebP/GIF, maksimal 2 MB. Kosongkan jika tidak diubah.</p>
    @if($article && $article->thumbnail_url)
      <div style="margin-top:10px;">
        <img src="{{ $article->thumbnail_url }}" alt="thumbnail" style="max-width:160px;border-radius:8px;border:1px solid #e3ddd0;">
      </div>
    @endif

    <label for="photo1">Foto di dalam artikel (maksimal 3)</label>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
      @foreach(['photo1'=>'Foto 1','photo2'=>'Foto 2','photo3'=>'Foto 3'] as $f => $lbl)
        <div style="border:1px solid #e3ddd0;border-radius:9px;padding:10px;">
          <strong style="font-size:13px;">{{ $lbl }}</strong>
          <input id="{{ $f }}" type="file" name="{{ $f }}" accept="image/*" style="margin:8px 0;">
          <label style="font-size:12px;color:#7a7165;display:block;">Taruh setelah paragraf ke-</label>
          <select name="{{ $f }}_after" style="width:100%;padding:6px 8px;border:1px solid #e3ddd0;border-radius:6px;font:inherit;font-size:13px;">
            <option value="">Otomatis (selang-seling)</option>
            @for($i = 1; $i <= 10; $i++)
              <option value="{{ $i }}" {{ old($f.'_after', $article->{$f.'_after'} ?? '') == $i ? 'selected' : '' }}>Paragraf {{ $i }}</option>
            @endfor
          </select>
          @if($article && $article->{$f.'_url'})
            <img src="{{ $article->{$f.'_url'} }}" alt="" style="max-width:100%;margin-top:8px;border-radius:6px;border:1px solid #e3ddd0;">
          @endif
        </div>
      @endforeach
    </div>
    <p class="hint">Pilih "setelah paragraf ke-berapa" foto mau muncul. Kosongkan = otomatis selang-seling. Foto yang tak dipakai dibiarin kosong.</p>

    <label for="body">Isi Artikel</label>
    <textarea id="body" name="body" placeholder="Tulis isi berita di sini. Cukup pakai enter untuk pindah paragraf baru.">{{ old('body', $article->body ?? '') }}</textarea>
    <p class="hint">Cukup ngetik seperti di catatan. Enter 2x = paragraf baru. Tidak perlu pakai kode HTML.</p>

    <div class="row2">
      <div>
        <label for="published_at">Tanggal Publikasi</label>
        <input id="published_at" type="datetime-local" name="published_at"
          value="{{ old('published_at', optional($article)->published_at ? optional($article)->published_at->format('Y-m-d\TH:i') : '') }}">
      </div>
      <div>
        <label>Status</label>
        <div style="padding-top:10px;">
          <label style="display:inline-flex;align-items:center;gap:8px;font-weight:500;margin:0;">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article && $article->published_at ? true : false) ? 'checked' : '' }}>
            Publikasikan sekarang
          </label>
        </div>
      </div>
    </div>

    <div class="checks">
      <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}> Artikel unggulan</label>
      <label><input type="checkbox" name="is_lead" value="1" {{ old('is_lead', $article->is_lead ?? false) ? 'checked' : '' }}> Jadi berita utama (lead)</label>
    </div>

    <div class="actions">
      <button class="btn btn-save" type="submit">{{ $article ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}</button>
      <a href="{{ route('admin.articles.index') }}" class="btn btn-cancel">Batal</a>
    </div>
  </form>
</div>
</body>
</html>
