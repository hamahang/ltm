<script>
    window['sys_requests_grid_columns'] = [
        {
            "data": "id", 'name':'id', 'title': 'ردیف',
            width: '5%',
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            width: '25%',
            data: 'title', name: 'title', 'title': 'فرآیند',
        },
        {
            width: '20%',
            data: 'tracking_code', name: 'tracking_code', 'title': 'کد رهگیری',
        },
        {
            width: '5%',
            data: 'status', name: 'status', 'title': 'وضعیت',
        }
    ];
    var getSysRequestsRoute = '{{ route('ltm.account.get_requests') }}';

    $(document).ready(function () {
        dataTablesGrid('#SysRequestsGridData', 'SysRequestsGridData', getSysRequestsRoute, sys_requests_grid_columns, {process_id: -1}, null, true);

        $(document).on("click", ".btn_filter_datatables", function () {
            $('.sys_requests_datatable_filters').fadeToggle(200);
        });

        init_select2_ajax('#filter_process', '{{ route('autocomplete.process') }}', true);

        $('#filter_process').change(function () {
            var filter_user = '';
            if ($('#filter_user').val()) {
                filter_user = $('#filter_user').val();
            }
            else {
                filter_user = -1;
            }
            dataTablesGrid('#SysRequestsGridData', 'SysRequestsGridData', getSysRequestsRoute, sys_requests_grid_columns, {process_id: $(this).val(), user_id: filter_user});
        });
    });
</script>