<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — QuartaNews Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Newsreader:wght@700&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;}
  body{margin:0;font-family:'Inter',system-ui,sans-serif;background:#faf8f3;color:#1a1714;
    min-height:100vh;display:grid;place-items:center;padding:24px;}
  .card{background:#fff;border:1px solid #e3ddd0;border-radius:14px;padding:36px;width:100%;max-width:380px;
    box-shadow:0 10px 40px rgba(0,0,0,.06);}
  .brand{font-family:'Newsreader',serif;font-weight:700;font-size:34px;text-align:center;margin:0 0 4px;}
  .brand .q{color:#b4231c;}
  .sub{text-align:center;color:#7a7165;font-size:13px;letter-spacing:.18em;text-transform:uppercase;margin-bottom:26px;}
  label{display:block;font-size:13px;font-weight:600;color:#443d35;margin:14px 0 6px;}
  input{width:100%;padding:11px 13px;border:1px solid #e3ddd0;border-radius:9px;font:inherit;font-size:14px;background:#faf8f3;}
  input:focus{outline:none;border-color:#b4231c;background:#fff;}
  button{width:100%;margin-top:22px;padding:12px;border:0;border-radius:9px;background:#b4231c;color:#fff;
    font:inherit;font-weight:600;cursor:pointer;}
  button:hover{background:#931b15;}
  .err{background:#f4e4e1;color:#931b15;border:1px solid #e7bdb8;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:6px;}
  .back{text-align:center;margin-top:16px;font-size:13px;}
  .back a{color:#b4231c;font-weight:600;}
</style>
</head>
<body>
  <form class="card" method="POST" action="{{ route('login') }}">
    @csrf
    <h1 class="brand"><span class="q">Q</span>uartaNews</h1>
    <p class="sub">Admin Login</p>

    @if($errors->any())
      @foreach($errors->all() as $e)
        <div class="err">{{ $e }}</div>
      @endforeach
    @endif

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <button type="submit">Masuk</button>
    <p class="back"><a href="{{ route('home') }}">← Kembali ke beranda</a></p>
  </form>
</body>
</html>
