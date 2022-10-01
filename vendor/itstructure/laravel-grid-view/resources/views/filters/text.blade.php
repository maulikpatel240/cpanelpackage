@php
/** @var string $name */
/** @var string $value onfocusout="if($(this).val()){$('#grid_view_filters_form').submit();}"*/
@endphp
@if ($name)
    <input type="text" id="grid-filter-filters[{{ $name }}]" class="form-control grid-filter" name="filters[{{ $name }}]" value="{{ $value }}" role="grid-view-filter-item" form="grid_view_filters_form" onfocusout="$('#grid_view_filters_form').submit();"">
@endif
