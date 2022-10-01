<?php
// echo '<pre>'; print_r($toolbar); echo '<pre>';dd();
?>
@php
/** @var \Itstructure\GridView\Columns\BaseColumn[] $columnObjects */
/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
/** @var boolean $useFilters */
$checkboxesExist = false;
$sort = request()->sort;
$removeOperatorInSort = $sort && mb_strpos($sort, '-') === 0 ? substr($sort, 1) : $sort;
$sortingClass = 'sorting';
if ($sort) {
    $sortingClass = mb_strpos($sort, '-') === 0 ? 'sorting sorting_desc' : 'sorting sorting_asc';
}
@endphp
<style>
    .table-bordered tfoot tr td {
        border-width: 0;
    }
</style>
@php
$resetbtnOption = 'class="btn btn-warning"';
$searchbtnOption = 'class="btn btn-primary"';
if (isset($toolbar['resetbtn']) && $toolbar['resetbtn']) {
    $keys = array_keys($toolbar['resetbtn']);
    $values = array_values($toolbar['resetbtn']);
    $attribute = [];
    for ($i = 0; $i < count($keys); $i++) {
        $attribute[] = $keys[$i] . '="' . $values[$i] . '"';
    }
    $resetbtnOption = $attribute ? implode(' ', $attribute) : '';
}

if (isset($toolbar['searchbtn']) && $toolbar['searchbtn']) {
    $keys = array_keys($toolbar['searchbtn']);
    $values = array_values($toolbar['searchbtn']);
    $attribute = [];
    for ($i = 0; $i < count($keys); $i++) {
        $attribute[] = $keys[$i] . '="' . $values[$i] . '"';
    }
    $searchbtnOption = $attribute ? implode(' ', $attribute) : '';
}
@endphp
<div id="gridtable-pjax" data-pjax-container="" data-pjax-push-state data-pjax-timeout="1000">
    <div class="kv-loader-overlay">
        <div class="kv-loader"></div>
    </div>
    <div class="{!! $id !!}" class="grid-view is-bs5 kv-grid-bs5 hide-resize">
        <div class="card">

            @if ($header)
                <div class="card-header bg-primary text-white">
                    <div class="float-end">
                        @if ($paginator->onFirstPage())
                            {!! trans('grid_view::grid.page-info', [
                                'start' => '<b>1</b>',
                                'end' => '<b>' . $paginator->perPage() . '</b>',
                                'total' => '<b>' . $paginator->total() . '</b>',
                            ]) !!}
                        @elseif ($paginator->currentPage() == $paginator->lastPage())
                            {!! trans('grid_view::grid.page-info', [
                                'start' => '<b>' . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . '</b>',
                                'end' => '<b>' . $paginator->total() . '</b>',
                                'total' => '<b>' . $paginator->total() . '</b>',
                            ]) !!}
                        @else
                            {!! trans('grid_view::grid.page-info', [
                                'start' => '<b>' . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . '</b>',
                                'end' => '<b>' . $paginator->currentPage() * $paginator->perPage() . '</b>',
                                'total' => '<b>' . $paginator->total() . '</b>',
                            ]) !!}
                        @endif
                    </div>
                    @if ($title)
                        <h5 class="m-0">{!! $title !!}</h5>
                    @endif
                </div>
            @endif

            @if (isset($toolbar['kv-panel-before']) && $toolbar['kv-panel-before'])
                <div class="kv-panel-before">
                    @php
                        if (isset($toolbar['kv-panel-before']['topcontent']) && $toolbar['kv-panel-before']['topcontent']) {
                            echo '<div>' . $toolbar['kv-panel-before']['topcontent'] . '</div>';
                        }
                    @endphp
                    @if ($searchable)
                        <div class="btn-toolbar kv-grid-toolbar toolbar-container float-start">
                            @php
                                if (isset($toolbar['kv-panel-before']['filter']) && $toolbar['kv-panel-before']['filter']) {
                                    echo $toolbar['kv-panel-before']['filter'];
                                }
                            @endphp
                        </div>
                    @endif
                    <div class="btn-toolbar kv-grid-toolbar toolbar-container float-end">
                        @php
                            if (isset($toolbar['kv-panel-before']['content']) && $toolbar['kv-panel-before']['content']) {
                                echo $toolbar['kv-panel-before']['content'];
                            }
                        @endphp
                        @if ($useFilters)
                            <div class="btn-group" role="group">
                                @if (isset($toolbar['resetbtn']) && $toolbar['resetbtn'])
                                    <button id="grid_view_reset_button" type="button"
                                        @php echo $resetbtnOption @endphp>{{ $resetButtonLabel }}</button>
                                @endif
                                {{-- <button id="grid_view_search_button" type="button" @php echo $searchbtnOption @endphp>{{
                            $searchButtonLabel }} <i class="fas fa-filter"></i></button> --}}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <form action="{{ $rowsFormAction }}" method="post" id="grid_view_rows_form">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
            </form>
            <div class="">
                <div class="table-responsive kv-grid-container" id="{!! $id !!}-container">
                    <table
                        class="kv-grid-table table @if ($tableBordered) table-bordered @endif @if ($tableStriped) table-striped @endif @if ($tableHover) table-hover @endif @if ($tableSmall) table-sm @endif">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                @foreach ($columnObjects as $column_obj)
                                    @if ($column_obj->getSort() === false || $column_obj instanceof \Itstructure\GridView\Columns\ActionColumn)
                                        @php
                                            $class = '';
                                        @endphp
                                    @elseif($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                        @php
                                            $class = '';
                                        @endphp
                                    @else
                                        @php
                                            $class = $column_obj->getAttribute() === $removeOperatorInSort ? $sortingClass : 'sorting';
                                        @endphp
                                    @endif
                                    <th {!! $column_obj->buildHtmlAttributes($class) !!}>
                                        @if ($column_obj->getSort() === false || $column_obj instanceof \Itstructure\GridView\Columns\ActionColumn)
                                            {{ $column_obj->getLabel() }}
                                        @elseif($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                            @php($checkboxesExist = true)
                                            @if ($useFilters)
                                                {{ $column_obj->getLabel() }}
                                            @else
                                                <input type="checkbox" id="grid_view_checkbox_main"
                                                    class="form-check-input kv-all-select"
                                                    @if ($paginator->count() == 0) disabled="disabled" @endif />
                                            @endif
                                        @else
                                            <a href="{{ \Itstructure\GridView\Helpers\SortHelper::getSortableLink(request(), $column_obj) }}"
                                                class="" data-trigger-pjax=1>{{ $column_obj->getLabel() }}</a>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>

                            @if ($useFilters)
                                <tr class="filter-header" id="gridtablefilter">
                                    <form action="{!! $filterUrl !!}" method="get" id="grid_view_filters_form"
                                        data-trigger-pjax="1">
                                        <td></td>
                                        @foreach ($columnObjects as $column_obj)
                                            <td>
                                                @if ($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                                    <div class="text-center">
                                                        <input type="checkbox" id="grid_view_checkbox_main"
                                                            class="form-check-input kv-all-select"
                                                            @if ($paginator->count() == 0) disabled="disabled" @endif />
                                                    </div>
                                                @else
                                                    {!! $column_obj->getFilter()->render() !!}
                                                @endif
                                            </td>
                                        @endforeach
                                        <button type="submit" class="btn btn-outline-primary grid-filter-button d-none"
                                            id="grid-filter-button" form="grid_view_filters_form"
                                            title="filter data">Filter&nbsp;<i class="fas fa-filter"></i></button>
                                    </form>
                                </tr>
                            @endif
                        </thead>
                        <tbody>
                            @if ($paginator->items())
                                @foreach ($paginator->items() as $key => $row)
                                    <tr class="gridtable">
                                        @if ($useInlineEdit)
                                            <td class="text-center">
                                                {{ ($paginator->currentPage() - 1) * $paginator->perPage() + $key + 1 }}
                                            </td>
                                            @foreach ($columnObjects as $column_obj)
                                                @if ($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                                    <td class="kv-row-select text-center">{!! $column_obj->render($row) !!}</td>
                                                @elseif ($column_obj instanceof \Itstructure\GridView\Columns\ActionColumn)
                                                    <td class="">
                                                        {!! $column_obj->render($row) !!}
                                                    </td>
                                                @else
                                                    <?php
                                                    $input = '';
                                                    $errorMsg = '';
                                                    if ($column_obj->getInlineEdit()) {
                                                        $inlineeditbox = $column_obj->getInlineEditBox();
                                                        $type = isset($inlineeditbox['type']) && $inlineeditbox['type'] ? $inlineeditbox['type'] : 'text';
                                                        $placeholder = isset($inlineeditbox['placeholder']) && $inlineeditbox['placeholder'] ? $inlineeditbox['placeholder'] : '';
                                                        $class = isset($inlineeditbox['class']) && $inlineeditbox['class'] ? $inlineeditbox['class'] : '';
                                                        $id = isset($inlineeditbox['id']) && $inlineeditbox['id'] ? $inlineeditbox['id'] : 'editform-' . $key . '-' . $column_obj->getAttribute();
                                                        $name = isset($inlineeditbox['name']) && $inlineeditbox['name'] ? $inlineeditbox['name'] : $column_obj->getAttribute();
                                                        $value = isset($inlineeditbox['value']) && $inlineeditbox['value'] ? $inlineeditbox['value'] : $column_obj->render($row);
                                                        $onchange = isset($inlineeditbox['onchange']) && $inlineeditbox['onchange'] ? $inlineeditbox['onchange'] : '';
                                                        $errorMsg = '<span class="invalid-feedback invalid-feedback-' . $name . '"></span>';
                                                        if ($type == 'date') {
                                                            $value = $value ? \Carbon\Carbon::parse(str_replace('/', '-', $value))->format('Y-m-d') : '';
                                                        }

                                                        $arrayobj = [
                                                            'class' => $class,
                                                            'id' => $id,
                                                            'placeholder' => $placeholder,
                                                        ];
                                                        $arrayobj = array_merge($arrayobj, $inlineeditbox);
                                                        if ($onchange) {
                                                            $arrayobj = array_merge($arrayobj, ['onchange' => $onchange]);
                                                        }
                                                        if ($type == 'select') {
                                                            $data = isset($inlineeditbox['data']) && $inlineeditbox['data'] ? $inlineeditbox['data'] : '';
                                                            $input = Form::select($name, $data, $value, $arrayobj);
                                                        } elseif ($type == 'textarea') {
                                                            $input = Form::textarea($name, $value, $arrayobj);
                                                        } else {
                                                            $input = Form::text($name, $value, $arrayobj);
                                                            if ($type == 'date') {
                                                                $input = Form::date($name, $value, $arrayobj);
                                                            }
                                                            if ($type == 'checkbox') {
                                                                $input = Form::checkbox($name, $value, $arrayobj);
                                                            }
                                                            if ($type == 'radio') {
                                                                $input = Form::radio($name, $value, $arrayobj);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <td class="" data-edit="{{ $column_obj->getInlineEdit() }}">
                                                        <span class="grid-view-text">{!! $column_obj->render($row) !!}</span>
                                                        <div class="grid-view-text-form" style="display: none;">
                                                            {!! $column_obj->getInlineEdit() ? $input : '' !!}{!! $column_obj->getInlineEdit() ? $errorMsg : '' !!}</div>
                                                    </td>
                                                @endif
                                            @endforeach
                                        @else
                                            <td class="text-center">
                                                {{ ($paginator->currentPage() - 1) * $paginator->perPage() + $key + 1 }}
                                            </td>
                                            @foreach ($columnObjects as $column_obj)
                                                @if ($column_obj instanceof \Itstructure\GridView\Columns\CheckboxColumn)
                                                    <td class="kv-row-select text-center">{!! $column_obj->render($row) !!}</td>
                                                @else
                                                    <td class="" data-edit="{{ $column_obj->getInlineEdit() }}">
                                                        {!! $column_obj->render($row) !!}
                                                    </td>
                                                @endif
                                            @endforeach
                                        @endif

                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td class="text-center" colspan="100">No record found.</td>
                                </tr>
                            @endif
                        </tbody>
                        {{-- <tfoot>
                                <tr>
                                    <td colspan="{{ count($columnObjects) + 1 }}">
                                        <div class="mx-1">
                                            <div class="row">
                                                <div class="col-12 col-xl-4 text-center text-xl-start d-flex">
                                                    @if (isset($toolbar['applybtn']))
                                                        {!! $toolbar['applybtn'] !!}
                                                    @elseif (($checkboxesExist || $useSendButtonAnyway) && $paginator->count() > 0)
                                                            <button type="submit" class="btn btn-danger">{{ $sendButtonLabel }}</button>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-xl-12 text-center">
                                                    {{ $paginator->render('grid_view::pagination') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot> --}}

                    </table>
                </div>
            </div>
            @if (isset($toolbar['kv-panel-after']) && $toolbar['kv-panel-after'])
                <div class="kv-panel-after p-3">
                    @if (isset($toolbar['kv-panel-after']['content']) && $toolbar['kv-panel-after']['content'])
                        {!! $toolbar['kv-panel-after']['content'] !!}
                        {{-- @elseif (($checkboxesExist || $useSendButtonAnyway) && $paginator->count() > 0)
                                <button type="submit" class="btn btn-danger">{{ $sendButtonLabel }}</button> --}}
                    @endif
                </div>
            @endif

            <div class="card-footer">
                <div class="kv-panel-pager text-center">
                    {{ $paginator->render('grid_view::pagination') }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        onInit();
    });

    function onInit() {
        $('#grid_view_checkbox_main').click(function(event) {
            // console.log(event.target.checked);
            if (event.target.checked === true) {
                if ($('#applycontent').length > 0) {
                    $('#applycontent').css("display", 'block');
                }
                $('tr.gridtable').addClass('table-danger');
            } else {
                if ($('#applycontent').length > 0) {
                    $('#applycontent').css("display", 'none');
                }
                $('tr.gridtable').removeClass('table-danger');
            }
            $('input[role="grid-view-checkbox-item"]').prop('checked', event.target.checked);
        });
        $('#grid_view_search_button').click(function() {
            $('#grid_view_filters_form').submit();
        });

        $('#grid_view_reset_button').click(function() {
            $('input[role="grid-view-filter-item"]').val('');
            $('select[role="grid-view-filter-item"]').prop('selectedIndex', 0);
        });
    }

    $(document).on('click', '.inlineEditForm', function() {
        $('.inlineEditForm').parents("tr").removeAttr("id");
        $(".grid-view-text").css("display", "block");
        $('.inlineEditForm').parents("tr").find(".grid-view-text-form").css("display", "none");
        $('.inlineEditForm').parents("tr").find(".inlineEditForm").removeClass("btn btn-primary btn-sm submit")
            .html('<i class="fas fa-edit"></i>');
        var $row = $(this).parents("tr");
        $row.attr("id", "editing");
        var $td = $("tr[id='editing'] td[data-edit='1']");
        $td.find(".grid-view-text").css("display", "none");
        $(this).parents("tr[id='editing']").find(".grid-view-text-form").css("display", "block");
        $(this).parents("tr[id='editing']").find(".inlineEditForm").addClass("btn btn-primary btn-sm submit")
            .html("Done");
        return false;
    });
    $(document).on('click', '.submit', function(event) {
        event.preventDefault();
        var $this = $(this);
        // var action = $(this).parent().parent('td').data("action");
        var action = $(this).data("action");
        var url = (action === "undefined" ? "/" : action);
        var row = $(this).parents("tr").first();
        var data = row.find("input, select, radio").serialize();
        // console.log(data);
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            beforeSend: function() {
                $(nameloader).show();
            },
            success: function(response) {
                // $('#gridviewModal').find('#modalContent').html(response);
                $.pjax.reload({
                    container: "#gridtable-pjax"
                });
            },
            complete: function() {
                $(nameloader).hide();
            },
            error: function(response) {
                resultthis = $this;
                result = data;
                var errordata = response.responseJSON;
                const searchParams = new URLSearchParams("?" + result);
                for (const key of searchParams.keys()) {
                    if (errordata.errors && errordata.errors[key] != undefined) {
                        resultthis.closest('tr[id="editing"]').find(
                            "td .grid-view-text-form .invalid-feedback-" + key).html(errordata
                            .errors[key][0]);
                        resultthis.closest('tr[id="editing"]').find(
                            "td .grid-view-text-form .invalid-feedback-" + key).css("display",
                            "block");
                    } else {
                        resultthis.closest('tr[id="editing"]').find(
                            "td .grid-view-text-form .invalid-feedback-" + key).html("");
                        resultthis.closest('tr[id="editing"]').find(
                            "td .grid-view-text-form .invalid-feedback-" + key).css("display",
                            "none");
                    }
                }



            },
        });
        return false;
    });
</script>
@push('grid_js')
    <script>
        (function($) {
            var grid = "#gridtable-pjax";
            var filterForm = "#grid_view_filters_form";
            var searchForm = "";
            _grids.grid.init({
                id: grid,
                filterForm: filterForm,
                dateRangeSelector: '.date-range',
                //   searchForm: searchForm,
                pjax: {
                    pjaxOptions: {
                        scrollTo: false,
                    },
                    // what to do after a PJAX request. Js plugins have to be re-intialized
                    afterPjax: function(e) {
                        _grids.init();
                        onInit();
                    },
                },
            });
        })(jQuery);
    </script>
@endpush
