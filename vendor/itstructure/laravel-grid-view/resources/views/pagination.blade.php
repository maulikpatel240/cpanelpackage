@php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var array[] $elements
 */
// $fullurlQuery = parse_url(url()->full());
$filterUrl['filters'] = isset($_GET['filters']) ? $_GET['filters']: '';
$searchUrl['q'] = isset($_GET['q']) ? $_GET['q']: '';
$filtersearchUrl = http_build_query(array_merge($filterUrl, $searchUrl));
@endphp

@if ($paginator->hasPages())
    <nav class="d-inline-flex">
        <ul class="pagination justify-content-center align-self-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" data-trigger-pjax="1" href="#">&laquo;</a>
                </li>
            @else
                @php  
                    $pageUrl = \Itstructure\GridView\Helpers\UrlSliderHelper::previousPageUrl(request(), $paginator);
                    if($filtersearchUrl){
                        $pageUrl = $pageUrl.'&'.$filtersearchUrl;
                    }
                @endphp
                <li class="page-item">
                    <a class="page-link" data-trigger-pjax="1" href="{{ $pageUrl }}">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach($elements as $key => $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            @php  
                                $pageUrl = \Itstructure\GridView\Helpers\UrlSliderHelper::toPageUrl(request(), $paginator, $page);
                                if($filtersearchUrl){
                                    $pageUrl = $pageUrl.'&'.$filtersearchUrl;
                                }
                            @endphp
                            <li class="page-item"><a class="page-link" data-trigger-pjax="1" href="{{ $pageUrl }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                {{-- "Three Dots" Separator --}}
                @elseif(is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                @php  
                    $pageUrl = \Itstructure\GridView\Helpers\UrlSliderHelper::nextPageUrl(request(), $paginator);
                    if($filtersearchUrl){
                        $pageUrl = $pageUrl.'&'.$filtersearchUrl;
                    }
                @endphp                 
                <li class="page-item">
                    <a class="page-link" data-trigger-pjax="1" href="{{ $pageUrl }}">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" data-trigger-pjax="1" href="#">&raquo;</a>
                </li>
            @endif
        </ul>
    </nav>
    <div class="clearfix"></div>
@endif
