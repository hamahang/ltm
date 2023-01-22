<div>
    <input type="button" class="btn btn-success hidden" id="btn_insert_task_{{$variable}}" value="افزودن درخواست"/>
    <input type="button" class="btn btn-info hidden" id="btn_insert_track_task_{{$variable}}" value="ثبت و ارسال پیام"/>
    <input type="button" class="btn btn-default" id="btn_close_task_{{$variable}}" value="بستن پنجره"/>
</div>
<script>
    $(document).off('click', "#btn_insert_task_{{$variable}}");
    $(document).on('click', "#btn_insert_task_{{$variable}}", function () {
        $("#submit_insert_task_{{$variable}}").click();
    });
    $("#btn_insert_track_task_{{$variable}}").click(function () {
        $("#submit_insert_track_task_{{$variable}}").click();
    });
    $("#btn_close_task_{{$variable}}").click(function () {
        var variable = "{{$variable}}";
        window[variable].close();
    });
</script>
