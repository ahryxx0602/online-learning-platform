@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center custom-pagination mt-4 mb-4">
        {{-- Phần text hiển thị (Showing 1 to 2 of 3 results) --}}
        <div class="pagination-text text-muted d-none d-sm-block">
            <small>
                {!! __('Showing') !!}
                <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-bold text-dark">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-bold text-dark">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </small>
        </div>

        {{-- Phần nút phân trang --}}
        <div>
            <ul class="pagination mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif