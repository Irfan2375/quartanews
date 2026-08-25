<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Artikel — QuartaNews Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Newsreader:wght@700&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;}
  body{margin:0;font-family:'Inter',system-ui,sans-serif;background:#faf8f3;color:#1a1714;}
  .wrap{max-width:1080px;margin:0 auto;padding:24px;}
  header{display:flex;justify-content:space-between;align-items:center;border-bottom:3px double #1a1714;padding-bottom:14px;margin-bottom:22px;}
  .brand{font-family:'Newsreader',serif;font-weight:700;font-size:28px;}
  .brand .q{color:#b4231c;}
  nav a{color:#443d35;font-weight:600;font-size:13.5px;text-decoration:none;margin-left:18px;}
  nav a:hover{color:#b4231c;}
  .status{background:#eef5ee;border:1px solid #cfe3cf;color:#2f6b2f;padding:10px 14px;border-radius:8px;font-size:14px;margin-bottom:18px;}
  table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #e3ddd0;border-radius:10px;overflow:hidden;}
  th,td{text-align:left;padding:12px 14px;border-bottom:1px solid #eef0ea;font-size:14px;}
  th{background:#f1ede4;font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#7a7165;}
  .cat{display:inline-block;background:#f4e4e1;color:#b4231c;font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:.05em;}
  .btn{padding:7px 12px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;display:inline-block;}
  .btn-edit{background:#1a1714;color:#faf8f3;}
  .btn-del{background:#f4e4e1;color:#931b15;}
  .btn-add{background:#b4231c;color:#fff;padding:10px 16px;}
  .btn-add:hover{background:#931b15;}
  form.del{display:inline;}
  .empty{text-align:center;color:#7a7165;padding:40px;}
  .badge{display:inline-block;font-size:11px;font-weight:700;padding:2px 8px;border-radius:12px;margin:1px 2px;}
  .badge.ok{background:#eef5ee;color:#2f6b2f;}
  .badge.draft{background:#f1ede4;color:#7a7165;}
  .badge.lead{background:#f4e4e1;color:#b4231c;}
  .badge.feat{background:#eae3f4;color:#5a3d8a;}
  .pagination{margin-top:18px;display:flex;gap:6px;flex-wrap:wrap;}
  .pg{padding:7px 12px;border:1px solid #e3ddd0;border-radius:7px;text-decoration:none;color:#443d35;font-size:13px;}
  .pg:hover{background:#f1ede4;}
  .pg.active{background:#1a1714;color:#fff;border-color:#1a1714;}
  .pg.disabled{color:#b3a99b;cursor:default;}
</style>
</head>
<body>
<div class="wrap">
  <header>
    <div class="brand"><span class="q">Q</span>uartaNews <span style="font-size:14px;color:#7a7165;font-family:'Inter';font-weight:500;">/ Admin</span></div>
    <nav>
      <a href="{{ route('admin.articles.create') }}" class="btn-add">+ Artikel Baru</a>
      <a href="{{ route('home') }}">Beranda</a>
      <a href="#" onclick="event.preventDefault();document.getElementById('logout').submit();">Logout</a>
      <form id="logout" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
    </nav>
  </header>

  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <table>
    <thead>
      <tr><th>Foto</th><th>Judul</th><th>Rubrik</th><th>Penulis</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      @forelse($articles as $a)
        <tr>
          <td style="width:64px;">
            @if($a->thumbnail_url)
              <img src="{{ $a->thumbnail_url }}" alt="" style="width:52px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #e3ddd0;">
            @else
              <span style="display:inline-block;width:52px;height:40px;border-radius:6px;background:#f1ede4;border:1px dashed #cfc7b8;"></span>
            @endif
          </td>
          <td style="font-weight:600;">{{ $a->title }}</td>
          <td><span class="cat">{{ $a->category }}</span></td>
          <td>{{ $a->author }}</td>
          <td>
            @if($a->published_at)
              <span class="badge ok">✓ Publikasi</span>
            @else
              <span class="badge draft">• Draft</span>
            @endif
            @if($a->is_lead)<span class="badge lead">Lead</span>@endif
            @if($a->is_featured)<span class="badge feat">Unggulan</span>@endif
          </td>
          <td>
            <a href="{{ route('admin.articles.edit', $a) }}" class="btn btn-edit">Edit</a>
            <form class="del" method="POST" action="{{ route('admin.articles.destroy', $a) }}" onsubmit="return confirm('Hapus artikel ini?');">
              @csrf @method('DELETE')
              <button class="btn btn-del" type="submit">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">Belum ada artikel.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="pagination">{{ $articles->links('vendor.pagination.admin') }}</div>
</div>
</body>
</html>
