@php
  $url = $article->thumbnail_url ?? '';
@endphp
@if($url)
  <img src="{{ $url }}" alt="{{ $article->title }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
@else
  <div style="position:absolute;inset:0;background:radial-gradient(circle at 70% 20%,var(--accent-soft),transparent 55%),repeating-linear-gradient(135deg,var(--paper-2) 0 14px,var(--line) 14px 15px);"></div>
  <span style="position:absolute;left:10px;bottom:8px;font-size:9px;letter-spacing:.2em;color:var(--muted);font-weight:600;">FOTO</span>
@endif
