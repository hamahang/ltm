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
        $(document).off('click', '.action_do_status').on('click', '.action_do_status', function()
        {
            if ('1' === $(this).val())
            {
                $('.action_do_status_percent').removeAttr('disabled').focus();
            } else
            {
                $('.action_do_status_percent').attr('disabled', 'disabled');
            }
        });
        $(document).off('click', '.btn_action').on('click', '.btn_action', function()
        {
            $.ajax
            ({
                type: 'post',
                url: '{{ route('ltm.clients.tasks.my_tasks.action')}}',
                dataType: 'json',
                data: $('.form_action').serialize(),
                success: function(result)
                {
                    if (true === result.status)
                    {
                        if (result.reload)
                        {
                            datatable_reload();
                        }
                        $('.btn_close').click();
                        alert(result.message);
                    } else if (-1 === result.status)
                    {
                        alert('خطایی رخ داده است.');
                        $('.total_loader').remove();
                    }
                }
            }).fail(function(result)
            {
                alert('خطای ' + result.statusText);
                $('.total_loader').remove();
            });
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
                {'title': 'تصویر', sortable: false},
                {'title': 'رونوشت'}
            ],
            data: {!! $transcripts_datatable_data !!},
            processing: false,
            serverSide: false
        });
    });
</script>
