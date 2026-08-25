@extends('layouts.app')

@section('title', $label . ' — QuartaNews')

@section('content')
<div style="border-bottom:3px double var(--ink);margin-bottom:28px;padding-bottom:10px;">
  <span class="kicker">{{ $label }}</span>
  <h1 style="font-family:'Newsreader',serif;font-weight:700;font-size:clamp(34px,6vw,56px);margin:0;letter-spacing:-.01em;">{{ $label }}</h1>
</div>

<section style="display:grid;grid-template-columns:repeat(3,1fr);gap:30px;">
  @forelse($articles as $a)
    <article>
      <div style="aspect-ratio:3/2;background:var(--paper-2);border:1px solid var(--line);margin-bottom:12px;position:relative;overflow:hidden;">
        @include('articles.partials.thumb', ['article' => $a])
      </div>
      <span class="kicker">{{ $label }}</span>
      <h3 style="font-family:'Newsreader',serif;font-weight:600;font-size:21px;line-height:1.18;margin:0 0 8px;"><a href="{{ route('article.show', $a) }}">{{ $a->title }}</a></h3>
      <p style="margin:0 0 10px;color:var(--ink-soft);font-size:14.5px;line-height:1.5;">{{ $a->excerpt }}</p>
      <p class="meta">Oleh <b>{{ $a->author }}</b> · {{ $a->published_at->diffForHumans() }}</p>
    </article>
  @empty
    <p style="color:var(--muted);">Belum ada artikel pada rubrik ini.</p>
  @endforelse
</section>

@if($articles->hasPages())
  <div style="margin:36px 0;display:flex;gap:10px;align-items:center;">
    {{ $articles->links() }}
  </div>
@endif
@endsection
