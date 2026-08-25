@if ($paginator->hasPages())
  <nav class="pagination" aria-label="Pagination">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
      <span class="pg disabled">« Prev</span>
    @else
      <a class="pg" href="{{ $paginator->previousPageUrl() }}">« Prev</a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="pg disabled">{{ $element }}</span>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="pg active">{{ $page }}</span>
          @else
            <a class="pg" href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
      <a class="pg" href="{{ $paginator->nextPageUrl() }}">Next »</a>
    @else
      <span class="pg disabled">Next »</span>
    @endif
  </nav>
@endif
