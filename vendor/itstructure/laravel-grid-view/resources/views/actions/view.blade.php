{{-- <div class="col-lg-{!! $bootstrapColWidth !!}"> --}}
@php
// $label = isset($htmlAttributes)
@endphp
<a href="{!! $url !!}" @if (!empty($htmlAttributes)) {!! $htmlAttributes !!} @endif>
    <i class="fas fa-eye"></i>
</a>
{{-- </div> --}}
