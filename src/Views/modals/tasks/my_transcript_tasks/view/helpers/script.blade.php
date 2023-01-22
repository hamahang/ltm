<script>
    function tab_action_type_click(e)
    {
        $('.action_type').prop('checked', false);
        $(e).prop('checked', true);
    }
    $(document).ready(function()
    {
        // inits
        init_select2_ajax('.action_transfer_user', '{{ route('ltm.auto_complete.users') }}', true);
        init_select2_ajax('.action_transfer_transcripts_cc', '{{ route('ltm.auto_complete.users') }}', true, true);
        init_select2_ajax('.action_transfer_transcripts_bcc', '{{ route('ltm.auto_complete.users') }}', true, true);
        //
        $(document).off('click', '.tabs').on('click', '.tabs', function()
        {
            if ('action' === $(this).data('tab-id'))
            {
                $('.btn_action').show();
            } else
            {
                $('.btn_action').hide();
            }
        });
        $(document).off('click', '.btn_close').on('click', '.btn_close', function()
        {
            $(this).parent().parent().find('.panel-heading .jsglyph-close').click();
        });
        $('.table_transcripts').DataTable
        ({
            columns:
            [
                {'title': 'ردیف'},
                {'title': 'نام'},
                {'title': 'نام کاربری'},
                {'title': 'تصویر', sortable: false}
            ],
            data: {!! $transcripts_datatable_data !!},
            processing: false,
            serverSide: false
        });
    });
</script>
