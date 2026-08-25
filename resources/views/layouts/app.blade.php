<!DOCTYPE html>
<html lang="id" data-theme="{{ $theme ?? 'light' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'QuartaNews — Portal Berita Independen')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,400;1,6..72,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --paper:#faf8f3; --paper-2:#f1ede4; --ink:#1a1714; --ink-soft:#443d35;
    --muted:#7a7165; --line:#e3ddd0; --accent:#b4231c; --accent-soft:#f4e4e1;
    --maxw:1180px;
  }
  [data-theme="dark"]{
    --paper:#15130f; --paper-2:#1f1c17; --ink:#f3eee6; --ink-soft:#cfc7ba;
    --muted:#968c7d; --line:#2c281f; --accent:#e0534a; --accent-soft:#2a1c1a;
  }
  *{box-sizing:border-box;}
  html{-webkit-text-size-adjust:100%;}
  body{margin:0;background:var(--paper);color:var(--ink);font-family:'Inter',system-ui,sans-serif;
    font-size:16px;line-height:1.6;-webkit-font-smoothing:antialiased;}
  a{color:inherit;text-decoration:none;}
  .wrap{max-width:var(--maxw);margin:0 auto;padding:0 24px;}
  .kicker{font-size:11.5px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;
    color:var(--accent);display:inline-block;margin-bottom:8px;}
  .meta{font-size:12.5px;color:var(--muted);letter-spacing:.02em;}
  .meta b{color:var(--ink-soft);font-weight:600;}

  .util{border-bottom:1px solid var(--line);font-size:12.5px;color:var(--muted);}
  .util .wrap{display:flex;justify-content:space-between;align-items:center;height:38px;}
  .util-mid{text-transform:uppercase;letter-spacing:.14em;font-weight:600;color:var(--ink-soft);}
  .util-right{display:flex;gap:18px;align-items:center;}
  .util-right a:hover{color:var(--ink);}

  .masthead{text-align:center;padding:30px 0 18px;border-bottom:3px double var(--ink);}
  .wordmark{font-family:'Newsreader',serif;font-weight:700;font-size:clamp(40px,8vw,76px);
    line-height:.92;letter-spacing:-.01em;margin:0;}
  .wordmark .q{color:var(--accent);}
  .tagline{margin:8px 0 0;font-size:12.5px;letter-spacing:.32em;text-transform:uppercase;
    color:var(--muted);font-weight:500;}

  nav.sections{border-bottom:1px solid var(--line);position:sticky;top:0;background:var(--paper);z-index:20;}
  nav.sections .wrap{display:flex;gap:26px;align-items:center;height:48px;overflow-x:auto;}
  nav.sections a{font-size:13.5px;font-weight:600;letter-spacing:.04em;color:var(--ink-soft);
    white-space:nowrap;padding:4px 0;border-bottom:2px solid transparent;}
  nav.sections a:hover,nav.sections a.active{color:var(--accent);border-bottom-color:var(--accent);}

  main{min-height:60vh;}

  footer{margin-top:56px;border-top:3px double var(--ink);background:var(--paper-2);}
  footer .wrap{padding:40px 24px;display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:30px;}
  .fbrand{font-family:'Newsreader',serif;font-weight:700;font-size:26px;}
  .fbrand .q{color:var(--accent);}
  footer p{color:var(--muted);font-size:13.5px;max-width:34ch;}
  footer h4{font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--ink);margin:0 0 12px;}
  footer ul{list-style:none;margin:0;padding:0;}
  footer li{margin:0 0 8px;}
  footer li a{color:var(--ink-soft);font-size:13.5px;}
  footer li a:hover{color:var(--accent);}
  .copy{border-top:1px solid var(--line);font-size:12px;color:var(--muted);text-align:center;padding:16px;}

  #tweaks{position:fixed;right:16px;bottom:16px;z-index:50;background:var(--paper);
    border:1px solid var(--line);border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.12);font-size:12.5px;width:200px;}
  #tweaks .th{display:flex;justify-content:space-between;align-items:center;padding:9px 12px;
    cursor:pointer;font-weight:600;border-bottom:1px solid var(--line);}
  #tweaks .body{padding:12px;display:none;}
  #tweaks.open .body{display:block;}
  #tweaks .row{margin-bottom:10px;}
  #tweaks label{display:block;color:var(--muted);margin-bottom:5px;}
  #tweaks .opts{display:flex;gap:6px;}
  #tweaks .opts button{flex:1;border:1px solid var(--line);background:var(--paper-2);color:var(--ink-soft);
    border-radius:6px;padding:6px 0;cursor:pointer;font:inherit;}
  #tweaks .opts button.on{background:var(--ink);color:var(--paper);border-color:var(--ink);}

  @media (max-width:860px){footer .wrap{grid-template-columns:1fr 1fr;}}
  @media (max-width:520px){.util-mid{display:none;}footer .wrap{grid-template-columns:1fr;}}
  @media (prefers-reduced-motion:reduce){*{transition:none!important;}}
</style>
@yield('head')
</head>
<body>

  <div class="util">
    <div class="wrap">
      <span>Edisi Online · Gratis</span>
      <span class="util-mid">{{ now()->translatedFormat('l, j F Y') }}</span>
      <span class="util-right">
        <a href="javascript:void(0)" onclick="document.getElementById('tweaks').classList.toggle('open')">Tampilan</a>
        <a href="{{ route('home') }}">Beranda</a>
      </span>
    </div>
  </div>

  <header class="masthead">
    <div class="wrap">
      <a href="{{ route('home') }}"><h1 class="wordmark"><span class="q">Q</span>uartaNews</h1></a>
      <p class="tagline">Portal Berita Independen · Sejak 2026</p>
    </div>
  </header>

  <nav class="sections">
    <div class="wrap">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      @foreach(App\Http\Controllers\ArticleController::CATEGORIES as $slug => $label)
        <a href="{{ route('category', $slug) }}"
           class="{{ request()->routeIs('category') && request()->route('category') === $slug ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </div>
  </nav>

  <main class="wrap" style="padding-top:32px;padding-bottom:32px;">
    @yield('content')
  </main>

  <footer>
    <div class="wrap">
      <div>
        <div class="fbrand"><span class="q">Q</span>uartaNews</div>
        <p>Portal berita independen yang menaruh urusan warga di halaman depan. Dikelola secara sukarela, tanpa iklan politik.</p>
      </div>
      <div>
        <h4>Rubrik</h4>
        <ul>@foreach(App\Http\Controllers\ArticleController::CATEGORIES as $slug => $label)
          <li><a href="{{ route('category', $slug) }}">{{ $label }}</a></li>
        @endforeach</ul>
      </div>
      <div>
        <h4>Tentang</h4>
        <ul><li><a href="#">Redaksi</a></li><li><a href="#">Kode Etik</a></li><li><a href="#">Kontak</a></li></ul>
      </div>
      <div>
        <h4>Berlangganan</h4>
        <ul><li><a href="#">Buletin Harian</a></li><li><a href="#">RSS</a></li><li><a href="#">Newsletter Opini</a></li></ul>
      </div>
    </div>
    <div class="copy">© 2026 QuartaNews · Konten sampel untuk keperluan portofolio.</div>
  </footer>

  <div id="tweaks">
    <div class="th" onclick="document.getElementById('tweaks').classList.toggle('open')">Tampilan ⚙</div>
    <div class="body">
      <div class="row"><label>Tema</label>
        <div class="opts" data-key="theme">
          <button data-val="light" class="on">Terang</button>
          <button data-val="dark">Gelap</button>
        </div></div>
    </div>
  </div>
<script>
  const root=document.documentElement;
  const saved={theme:localStorage.getItem('qn-theme')||'light'};
  function apply(){root.setAttribute('data-theme',saved.theme);sync();}
  function sync(){document.querySelectorAll('#tweaks .opts').forEach(g=>{const k=g.dataset.key;
    g.querySelectorAll('button').forEach(b=>b.classList.toggle('on',b.dataset.val===saved[k]));});}
  document.querySelectorAll('#tweaks .opts button').forEach(b=>{
    b.onclick=()=>{const k=b.parentElement.dataset.key;saved[k]=b.dataset.val;localStorage.setItem('qn-'+k,saved[k]);apply();};});
  apply();
</script>
</body>
</html>
