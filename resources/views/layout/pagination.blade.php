@if ($paginator->hasPages())
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span style="background-color: #f6f6f6;box-shadow: none;-webkit-box-shadow: none;"><i class="fa fa-angle-double-left"></i></span></li>
        @else
            <li><a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-double-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-double-right"></i></a></li>
        @else
            <li class="disabled"><span><i class="fa fa-angle-double-right"></i></span></li>
        @endif
    </ul>
@endif