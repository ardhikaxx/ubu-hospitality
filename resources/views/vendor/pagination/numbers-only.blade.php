@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center my-3" aria-label="Navigasi Halaman">
        <ul class="pagination ubu-pagination mb-0">
            {{-- Pagination Elements (Numbers Only) --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item ubu-page-item disabled" aria-disabled="true">
                        <span class="page-link ubu-page-link ubu-page-ellipsis">&hellip;</span>
                    </li>
                @endif

                {{-- Array Of Links (Numbers Only) --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item ubu-page-item active" aria-current="page">
                                <span class="page-link ubu-page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item ubu-page-item">
                                <a class="page-link ubu-page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
