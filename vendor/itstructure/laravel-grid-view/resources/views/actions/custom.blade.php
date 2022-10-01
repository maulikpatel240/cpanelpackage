{{-- <div class="col-lg-{!! $bootstrapColWidth !!}"> --}}
    @if($button)
        {!! $button !!}
    @else
    <a href="{!! $url !!}" @if(!empty($htmlAttributes)) {!! $htmlAttributes !!} @endif >
        {!! $label !!}
    </a>
    @endif
{{-- </div> --}}
