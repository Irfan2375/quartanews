@extends('layouts.app')

@section('title', $article->title . ' — QuartaNews')

@section('content')
<article style="max-width:760px;margin:0 auto;">
  <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$article->category] ?? $article->category }}</span>
  <h1 style="font-family:'Newsreader',serif;font-weight:700;font-size:clamp(32px,5vw,52px);line-height:1.06;letter-spacing:-.01em;margin:0 0 16px;text-wrap:pretty;">{{ $article->title }}</h1>
  <p style="font-size:20px;color:var(--ink-soft);line-height:1.5;margin:0 0 18px;">{{ $article->excerpt }}</p>
  <div style="display:flex;align-items:center;gap:12px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);padding:14px 0;margin-bottom:24px;">
    <div style="width:44px;height:44px;border-radius:50%;background:var(--ink);color:var(--paper);display:grid;place-items:center;font-weight:700;font-size:16px;">{{ mb_substr($article->author,0,1) }}</div>
    <div><b style="display:block;font-size:14.5px;">{{ $article->author }}</b><span style="font-size:12.5px;color:var(--muted);">{{ $article->published_at->translatedFormat('j F Y') }} · {{ $article->published_at->diffForHumans() }}</span></div>
  </div>

  @if($article->thumbnail_url)
    <img src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" style="width:100%;border-radius:10px;margin-bottom:28px;border:1px solid var(--line);">
  @endif

  @php
    $paras = array_filter(preg_split('/\n\s*\n/', $article->body ?? ''), fn($b) => trim($b) !== '');
    $photos = $article->photosWithPosition();
    $autoQueue = array_values(array_filter($photos, fn($p) => empty($p['after'])));
    $autoIdx = 0;
    $paraCount = 0;
  @endphp

  @foreach($paras as $para)
    <div style="font-size:18px;line-height:1.75;color:var(--ink);margin-bottom:22px;">
      {!! nl2br(e(trim($para)), false) !!}
    </div>
    @php $paraCount++; @endphp
    {{-- cek foto yang ditentukan posisinya persis setelah paragraf ini --}}
    @foreach($photos as $p)
      @if(!empty($p['after']) && (int)$p['after'] === $paraCount)
        <figure style="margin:0 0 28px;">
          <img src="{{ $p['url'] }}" alt="" style="width:100%;border-radius:10px;border:1px solid var(--line);">
        </figure>
      @endif
    @endforeach
    {{-- foto otomatis selang-seling tiap 2 paragraf --}}
    @if($paraCount % 2 === 0 && isset($autoQueue[$autoIdx]))
      <figure style="margin:0 0 28px;">
        <img src="{{ $autoQueue[$autoIdx]['url'] }}" alt="" style="width:100%;border-radius:10px;border:1px solid var(--line);">
      </figure>
      @php $autoIdx++; @endphp
    @endif
  @endforeach
</article>

@if($related->isNotEmpty())
  <section style="max-width:980px;margin:56px auto 0;border-top:3px double var(--ink);padding-top:24px;">
    <h2 style="font-family:'Newsreader',serif;font-weight:700;font-size:24px;margin:0 0 18px;">Baca Juga</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
      @foreach($related as $r)
        <article>
          <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$r->category] ?? $r->category }}</span>
          <h3 style="font-family:'Newsreader',serif;font-weight:600;font-size:18px;line-height:1.2;margin:5px 0;"><a href="{{ route('article.show', $r) }}">{{ $r->title }}</a></h3>
          <p class="meta">{{ $r->published_at->diffForHumans() }}</p>
        </article>
      @endforeach
    </div>
  </section>
@endif
@endsection
