@if ($paginator->hasPages())
    <?php
    $params = request()->all();
    if (isset($params['page'])) unset($params['page']);
    $params = http_build_query($params);
    if ($params) $params = '&'.$params;
    ?>
    <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="prev" href="javascript:void(0)" aria-label="Previous"></a>
            @else
                <a href="{{ $paginator->previousPageUrl().$params }}" class="prev"></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <a href="#" class="page">{{ $element }} </a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="current">{{ $page }}</a>
                        @else
                            <a href="{{ $url.$params }}" class="page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
               <a href="{{ $paginator->nextPageUrl().$params }}" class="next" rel="next"></a>
            @else
                <a class="next" href="javascript:void(0)" aria-label="Next"></a>
            @endif
    </div>
@endif