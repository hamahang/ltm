<script>
    var constraints =
    {};
    var form = document.querySelector('#form_action');
    var constraints_track =
    {
        description_track:{
            presence: {message: '^<strong>توضیحات الزامی است</strong>'}
        }
    };
    var form_track = document.querySelector('#form_track_task');
    init_validatejs(form_track, constraints_track, task_action_track, '#form_track_task');

    function task_action_track(formElement)
    {
        var formData = new FormData(formElement);
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.my_tasks.save_track')}}',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result)
            {
                $('.total_loader').remove();
                if (result.success)
                {
                    // $('a[href="#task_tracing"]').click();
                    // $('#track_description').val('');
                    // $('#result_track').html('');
                    $('#response').html(result.track_view) ;
                } else
                {
                    showMessages(result.message, 'form_message_box', 'error', formElement);
                    showErrors(form, result.errors);
                }
            }
        }).fail(function(result)
        {
            alert('خطای ' + result.statusText);
            $('.total_loader').remove();
        });
    }
    function task_action(formElement)
    {
        var formData = new FormData(formElement);
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.my_tasks.action')}}',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result)
            {
                if ('success' === result.status_type)
                {
                    if (result.reload)
                    {
                        datatable_reload();
                    }
                    $('.btn_close').click();
                } else
                {
                    showMessages(result.message, 'form_message_box', 'error', formElement);
                    showErrors(form, result.errors);
                    $('.total_loader').remove();
                }
            }
        }).fail(function(result)
        {
            alert('خطای ' + result.statusText);
            $('.total_loader').remove();
        });
    }
    init_validatejs(form, constraints, task_action, '#form_action',true);
    function tab_action_type_click(e, v)
    {
        o = $('.action_type');
        o.prop('checked', false);
        $(e).prop('checked', true);
        o.val(v);
        $('#action_do_status_0').click();
    }
    //
    $(document).off('click', '#action_do_status_0').on('click', '#action_do_status_0', function()
    {
        $('.action_do_status_percent').val(0);
        $('.message_a0').html('');
    });
    $(document).off('click', '.action_reject_accept').on('click', '.action_reject_accept', function()
    {
        $('.action_reject_accept').val($('.action_reject_accept').prop("checked"));
    });
    $(document).off('click', '.action_transfer_email, .action_transfer_sms, .action_transfer_messaging').on('click', '.action_transfer_email, .action_transfer_sms, .action_transfer_messaging', function()
    {
        $('.fg_' + $(this).attr('class')).toggle();
    });
    //
    $(document).ready(function()
    {
        // inits
        init_select2_ajax('.action_transfer_do_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        init_select2_ajax('.action_transfer_transfer_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        init_select2_ajax('.action_transfer_reject_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        init_select2_ajax('.action_transfer_user', '{{ route('ltm.auto_complete.users') }}', true);
        init_select2_ajax('.action_transfer_transcripts_cc', '{{ route('ltm.auto_complete.users') }}', true, true);
        init_select2_ajax('.action_transfer_transcripts_bcc', '{{ route('ltm.auto_complete.users') }}', true, true);
        //
        $(document).off('click', '.tabs').on('click', '.tabs', function()
        {
            if ('action' === $(this).data('tab-id') )
            {
                $('.btn_action').show();
            } else
            {
                $('.btn_action').hide();
            }
            if ('response' === $(this).data('tab-id'))
            {
                $('.btn_save_track').show();
            } else
            {
                $('.btn_save_track').hide();
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
            if ('2' === $(this).val())
            {
                $('.custom_action_do_form').show();
            } else
            {
                $('.custom_action_do_form').hide();
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
    $(document).off('click', '.btn_action').on('click', '.btn_action', function()
    {
        $('.submit_form_action').click();
    });

    $(document).off('click', '.btn_save_track').on('click', '.btn_save_track', function()
    {
        $('#submit_insert_track').click();
    });
</script>
