<script>
    $(document).off("click", ".btn_filter_datatables");
    $(document).on("click", ".btn_filter_datatables", function () {
        $('.forms_datatable_filters').fadeToggle(200);
    });
    var all_request_data = {!! json_encode($all_request_filter) !!};
    var all_form_data = {} ;

    init_select2_data("#filter_file_no", all_request_data, false, false, false, false, 'انتخاب شماره پرونده');
    init_select2_data("#filter_step_id", all_form_data, false, false, false, false, 'ابتدا شماره پرونده را انتخاب کنید...');
    $('#filter_file_no').on("select2:select", function (e) {
        var selected_data = e.params.data;
        selected_data.forms = selected_data.forms || {};
        $("#filter_step_id").html('<option></option>');
        if (selected_data.forms.length > 0) {
            $("#filter_step_id").select2("destroy");
            $("#filter_step_id").html('');
            $("#filter_step_id").html('<option></option>');
            init_select2_data("#filter_step_id", selected_data.forms, false, false, false, false, 'انتخاب گام');
        } else {
            $("#filter_step_id").select2("destroy");
            $("#filter_step_id").html('');
            $("#filter_step_id").html('<option></option>');
            init_select2_data("#filter_step_id", {}, false, false, false, false, 'ابتدا شماره پرونده را انتخاب کنید...');
        }
    });

    $(document).off("click", "#filter_data");
    $(document).on("click", "#filter_data", function () {
        TasksGridData.destroy();
        datatable_load_fun();
    });

    $(document).off("click", "#cancel_filter_data");
    $(document).on("click", "#cancel_filter_data", function () {
        $('#filter_file_no').val('').trigger('change');
        $('#filter_step_id').val('').trigger('change');
        init_select2_data("#filter_step_id", {}, false, false, false, false, 'ابتدا شماره پرونده را انتخاب کنید...');
        TasksGridData.destroy();
        datatable_load_fun();
    });
</script>