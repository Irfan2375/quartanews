@extends('layouts.app')

@section('title', 'QuartaNews — Portal Berita Independen')

@section('content')
@php
  $chunks = $latest->chunk(3);
  $techMain = $techFeature->first();
  $techRest = $techMain ? $techFeature->slice(1) : collect();
@endphp

{{-- LEAD --}}
<section style="display:grid;grid-template-columns:1.9fr 1fr;gap:40px;border-bottom:1px solid var(--line);padding-bottom:36px;">
  @if($lead)
  <article>
    <div style="aspect-ratio:16/9;background:var(--paper-2);border:1px solid var(--line);margin-bottom:18px;position:relative;overflow:hidden;">
      @include('articles.partials.thumb', ['article' => $lead])
    </div>
    <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$lead->category] ?? $lead->category }}</span>
    <h1 style="font-family:'Newsreader',serif;font-weight:700;font-size:clamp(30px,4.4vw,52px);line-height:1.04;letter-spacing:-.01em;margin:0 0 14px;">
      <a href="{{ route('article.show', $lead) }}">{{ $lead->title }}</a>
    </h1>
    <p style="font-size:18px;color:var(--ink-soft);margin:0 0 16px;line-height:1.5;max-width:62ch;">{{ $lead->excerpt }}</p>
    <p class="meta">Oleh <b>{{ $lead->author }}</b> · {{ $lead->published_at->translatedFormat('j F Y') }} · {{ $lead->published_at->diffForHumans() }}</p>
  </article>
  @endif

  <aside style="border-left:1px solid var(--line);padding-left:28px;">
    <p style="font-size:12px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--ink);margin:0 0 16px;padding-bottom:10px;border-bottom:2px solid var(--ink);">Berita Teratas</p>
    @foreach($topNews as $n)
      <article style="padding:14px 0;border-bottom:1px solid var(--line);">
        <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$n->category] ?? $n->category }}</span>
        <h3 style="font-family:'Newsreader',serif;font-weight:600;font-size:19px;line-height:1.2;margin:6px 0 6px;"><a href="{{ route('article.show', $n) }}">{{ $n->title }}</a></h3>
        <p class="meta">{{ $n->published_at->diffForHumans() }}</p>
      </article>
    @endforeach
  </aside>
</section>

{{-- TERBARU --}}
<div style="display:flex;align-items:baseline;justify-content:space-between;margin:42px 0 18px;border-bottom:1px solid var(--ink);padding-bottom:8px;">
  <h2 style="font-family:'Newsreader',serif;font-weight:700;font-size:26px;margin:0;">Terbaru</h2>
  <a href="{{ route('category', 'teknologi') }}" style="font-size:12.5px;font-weight:600;color:var(--accent);">Lihat semua →</a>
</div>
@foreach($chunks as $row)
<section style="display:grid;grid-template-columns:repeat(3,1fr);gap:30px;margin-bottom:30px;">
  @foreach($row as $a)
    <article>
      <div style="aspect-ratio:3/2;background:var(--paper-2);border:1px solid var(--line);margin-bottom:12px;position:relative;overflow:hidden;">
        @include('articles.partials.thumb', ['article' => $a])
      </div>
      <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$a->category] ?? $a->category }}</span>
      <h3 style="font-family:'Newsreader',serif;font-weight:600;font-size:21px;line-height:1.18;margin:0 0 8px;"><a href="{{ route('article.show', $a) }}">{{ $a->title }}</a></h3>
      <p style="margin:0 0 10px;color:var(--ink-soft);font-size:14.5px;line-height:1.5;">{{ $a->excerpt }}</p>
      <p class="meta">Oleh <b>{{ $a->author }}</b> · {{ $a->published_at->diffForHumans() }}</p>
    </article>
  @endforeach
</section>
@endforeach

{{-- FEATURE TEKNOLOGI --}}
<div style="display:flex;align-items:baseline;justify-content:space-between;margin:42px 0 18px;border-bottom:1px solid var(--ink);padding-bottom:8px;">
  <h2 style="font-family:'Newsreader',serif;font-weight:700;font-size:26px;margin:0;">Teknologi & Masa Depan</h2>
  <a href="{{ route('category', 'teknologi') }}" style="font-size:12.5px;font-weight:600;color:var(--accent);">Indeks →</a>
</div>
@if($techMain)
<section style="display:grid;grid-template-columns:1.4fr 1fr;gap:34px;align-items:start;">
  <article>
    <div style="aspect-ratio:16/10;background:var(--paper-2);border:1px solid var(--line);margin-bottom:14px;position:relative;overflow:hidden;">
      @include('articles.partials.thumb', ['article' => $techMain])
    </div>
    <span class="kicker">Telaah</span>
    <h3 style="font-family:'Newsreader',serif;font-weight:700;font-size:clamp(24px,3vw,34px);line-height:1.08;margin:0 0 10px;"><a href="{{ route('article.show', $techMain) }}">{{ $techMain->title }}</a></h3>
    <p style="color:var(--ink-soft);font-size:15.5px;margin:0 0 10px;">{{ $techMain->excerpt }}</p>
    <p class="meta">Oleh <b>{{ $techMain->author }}</b> · {{ $techMain->published_at->diffForHumans() }}</p>
  </article>
  <div style="border-top:1px solid var(--line);padding-top:14px;">
    @foreach($techRest as $t)
      <article style="padding:13px 0;border-bottom:1px solid var(--line);">
        <span class="kicker">{{ \App\Http\Controllers\ArticleController::CATEGORIES[$t->category] ?? $t->category }}</span>
        <h4 style="font-family:'Newsreader',serif;font-weight:600;font-size:17px;line-height:1.2;margin:5px 0;"><a href="{{ route('article.show', $t) }}">{{ $t->title }}</a></h4>
        <p class="meta">{{ $t->published_at->diffForHumans() }}</p>
      </article>
    @endforeach
  </div>
</section>
@endif

{{-- OPINI --}}
<div style="display:flex;align-items:baseline;justify-content:space-between;margin:42px 0 18px;border-bottom:1px solid var(--ink);padding-bottom:8px;">
  <h2 style="font-family:'Newsreader',serif;font-weight:700;font-size:26px;margin:0;">Opini</h2>
  <a href="{{ route('category', 'opini') }}" style="font-size:12.5px;font-weight:600;color:var(--accent);">Kirim Tulisan →</a>
</div>
<section style="display:grid;grid-template-columns:repeat(2,1fr);gap:34px;">
  @foreach($opinions as $o)
    <article style="border-top:3px solid var(--accent);padding-top:18px;">
      <a href="{{ route('article.show', $o) }}"><p style="font-family:'Newsreader',serif;font-style:italic;font-weight:500;font-size:22px;line-height:1.35;margin:0 0 14px;">“{{ $o->excerpt }}”</p></a>
      <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:50%;background:var(--ink);color:var(--paper);display:grid;place-items:center;font-weight:700;font-size:15px;">{{ mb_substr($o->author,0,1) }}</div>
        <div><b style="display:block;font-size:14px;">{{ $o->author }}</b><span style="font-size:12px;color:var(--muted);">Penulis Opini</span></div>
      </div>
    </article>
  @endforeach
</section>
@endsection
