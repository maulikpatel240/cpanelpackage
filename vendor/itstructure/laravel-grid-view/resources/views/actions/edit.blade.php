@php
$htmlAttributes1 = str_replace(['inlineEditForm', 'showModalButton'],[""],$htmlAttributes);
@endphp
{{-- <div class="col-lg-{!! $bootstrapColWidth !!}"> --}}
    @if (isset($url['is_status']) && $url['is_status'] === 3)
        <a  @if(!empty($htmlAttributes)) {!! $htmlAttributes1 !!} @endif >
            <i class="fas fa-edit"></i>
        </a>
    @elseif($url)
        <a href="{!! $url !!}" @if(!empty($htmlAttributes)) {!! $htmlAttributes !!} @endif data-action="{!! $updateUrl !!}">
            <i class="fas fa-edit"></i>
        </a>
    @endif
    
{{-- </div> --}}
