@php
/** @var string $name */
/** @var array $data */
/** @var mixed $value onchange="if($(this).val()){$('#grid_view_filters_form').submit();}*/
@endphp
@if ($name)
    <select id="grid-filter-filters[{{ $name }}]" class="form-select grid-filter" name="filters[{{ $name }}]" role="grid-view-filter-item" form="grid_view_filters_form" onchange="$('#grid_view_filters_form').submit();">
        <option value="">{!! trans('grid_view::grid.select') !!}</option>
        @foreach ($data as $key => $val)
            <option value="{!! $key !!}" @if ($value !== null && $value == $key) selected="selected" @endif>{!! $val !!}</option>
        @endforeach
    </select>
@endif
