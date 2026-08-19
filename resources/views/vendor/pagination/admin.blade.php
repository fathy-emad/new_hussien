@if ($paginator->hasPages())
    @php
        $pageElements = adminPaginationElements($paginator);
    @endphp
    <ul class="pagination admin-page-links mb-0">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link"><i class="bx bx-chevron-right"></i></span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bx bx-chevron-right"></i></a></li>
        @endif

        @foreach ($pageElements as $element)
            @if ($element['ellipsis'])
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @elseif ($element['page'] === $paginator->currentPage())
                <li class="page-item active"><span class="page-link">{{ $element['page'] }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $element['url'] }}">{{ $element['page'] }}</a></li>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bx bx-chevron-left"></i></a></li>
        @else
            <li class="page-item disabled"><span class="page-link"><i class="bx bx-chevron-left"></i></span></li>
        @endif
    </ul>
@endif
