@php
/** @var string $field */
/** @var mixed $value */

if($htmlContent){
    echo $htmlContent;
}else{
    echo '<input type="checkbox" class="form-check-input kv-row-checkbox" name="'.$field.'[]" value="'.$value.'" role="grid-view-checkbox-item" onchange="onclickcheckbox(this);" />';
}
@endphp

<script>
    var total_checkbox = $('input[role="grid-view-checkbox-item"]').length;

    function onclickcheckbox(e) {
        $(e).is(':checked') ? $(e).closest('.gridtable').addClass('table-danger') : $(e).closest('.gridtable').removeClass('table-danger');
        var selected = [];
        $('input[role="grid-view-checkbox-item"]:checked').each(function() {
            selected.push($(e).val());
        });
        if (!$(e).prop("checked")) {
            $("#grid_view_checkbox_main").prop("checked", false);
        } else {
            if (total_checkbox == selected.length) {
                $("#grid_view_checkbox_main").prop("checked", true);
            }
        }
        if (selected.length > 0) {
            if ($('#applycontent').length > 0) {
                $('#applycontent').css("display", 'block');
            }
        } else {
            if ($('#applycontent').length > 0) {
                $('#applycontent').css("display", 'none');
            }
        }

    }
</script>
