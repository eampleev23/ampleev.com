@if ($paginator->hasPages())
    <div class="row justify-content-between align-items-center pr-lg-4">
        <div class="col-auto">
            @if ($paginator->onFirstPage())
                <span class="btn btn-outline-white disabled">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-white">Previous</a>
            @endif
        </div>
        <div class="col-auto">
            <nav>
                <ul class="pagination mb-0">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="col-auto">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-white">Next</a>
            @else
                <span class="btn btn-outline-white disabled">Next</span>
            @endif
        </div>
    </div>
@endif


