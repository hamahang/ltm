<script>
    var general_deadline = '.general_deadline';
    var general_deadline_from_date = $('.general_deadline_from_date');
    var general_deadline_from_time = $('.general_deadline_from_time');
    var general_deadline_to_date = $('.general_deadline_to_date');
    var general_deadline_to_time = $('.general_deadline_to_time');
    var general_deadline_to_day = $('.general_deadline_to_day');
    var general_deadline_to_hourmin = $('.general_deadline_to_hourmin');
    var is_apply = false;
    var form = document.querySelector('#form_task_integrate');
    var constraints =
    {
        general_type:
        {
            presence: {message: '^<strong>نوع الزامی است</strong>'}
        },
        general_importance:
        {
            presence: {message: '^<strong>اهمیت الزامی است</strong>'}
        },
        general_immediate:
        {
            presence: {message: '^<strong>فوریت الزامی است</strong>'}
        },
        general_title:
        {
            presence: {message: '^<strong>عنوان الزامی است</strong>'}
        },
        general_subject_id:
        {
            presence: {message: '^<strong>موضوع الزامی است</strong>'}
        },
        general_user:
        {
            presence: {message: '^<strong>مسئول الزامی است</strong>'}
        },
        general_file_no:
        {
            presence: {message: '^<strong>شماره پرونده الزامی است</strong>'}
        }
    };
    function task_integrate(formElement)
    {
        var formData = new FormData(formElement);
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.task.integrate')}}',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result)
            {
                if ('success' === result.status_type)
                {
                    if (is_apply)
                    {
                        //$('.form_task_integrate').find('.total_loader').remove();
                        //alert(result.message);
                        JS_Panel.content.html('<div class="loader"></div>');
                        JS_Panel.find('.panel-footer').html('');
                        JS_Panel.contentReload();
                    } else
                    {
                        $('.btn_close').click();
                    }
                    //alert(result.message);
                    //messageModal('success', 'افزودن وظیفه جدید', {0: result.message});
                    datatable_reload();
                } else
                {
                    $('.form_task_integrate').find('.total_loader').remove();
                    showErrors(form, result.errors);
                    alert('خطایی رخ داده است.');
                    $('.total_loader').remove();
                    //messageModal('error', result.message.title, result.error);
                }
            }
        }).fail(function(result)
        {
            alert(result.statusText);
        });
    }
    init_validatejs(form, constraints, task_integrate,'#form_task_integrate');
    //
    $(document).ready(function()
    {
        // inits
        init_select2_ajax('.general_subject_id', '{{ route('ltm.auto_complete.subjects') }}', true);
        init_select2_ajax('.general_user',  '{{ route('ltm.auto_complete.users') }}', true, false);
        init_select2_ajax('.general_transcripts_cc', '{{ route('ltm.auto_complete.users') }}', true, true);
        init_select2_ajax('.general_transcripts_bcc', '{{ route('ltm.auto_complete.users') }}', true, true);
        init_select2_ajax('.general_keywords', '{{ route('ltm.auto_complete.keywords') }}', true, true, true);
        // datepickers
        $('.general_deadline_from_date, .general_deadline_to_date').pDatepicker({format: 'YYYY/MM/DD'});
        $('.general_deadline_from_time, .general_deadline_to_time').pDatepicker({format: 'hh:mm'});
        // general_deadline
        $(document).off('click', general_deadline).on('click', general_deadline, function()
        {
            var fg_general_deadline_from_to = $('.custom_group_general_deadline_from, .custom_group_general_deadline_to');
            switch ($(this).val())
            {
                case '1':
                    fg_general_deadline_from_to.hide();
                    break;
                case '2':
                    fg_general_deadline_from_to.show();
                    break;
            }
        });
        // general_deadline_from
        var general_deadline_from = '.general_deadline_from';
        $(document).off('change', general_deadline_from).on('change', general_deadline_from, function()
        {
            var fg_general_deadline_from_datetime = $('.fg_general_deadline_from_datetime');
            switch ($(this).find('option:selected').val())
            {
                case '1':
                    fg_general_deadline_from_datetime.hide();
                    general_deadline_from_date.pDatepicker({format: 'YYYY/MM/DD'});
                    general_deadline_from_time.pDatepicker({format: 'hh:mm'});
                    break;
                case '2':
                    fg_general_deadline_from_datetime.show();
                    break;
            }
        });
        // general_deadline_from
        var general_deadline_to = '.general_deadline_to';
        $(document).off('change', general_deadline_to).on('change', general_deadline_to, function()
        {
            var fg_general_deadline_to_duration = $('.fg_general_deadline_to_duration');
            var fg_general_deadline_to_datetime = $('.fg_general_deadline_to_datetime');
            switch ($(this).find('option:selected').val())
            {
                case '1':
                    fg_general_deadline_to_duration.show();
                    fg_general_deadline_to_datetime.hide();
                    break;
                case '2':
                    fg_general_deadline_to_duration.hide();
                    fg_general_deadline_to_datetime.show();
                    break;
            }
        });
        //
        $(document).off('click', '.setting_email, .setting_sms, .setting_messaging').on('click', '.setting_email, .setting_sms, .setting_messaging', function()
        {
            $('.fg_' + $(this).attr('class')).toggle();
        });
        //
        $(document).off('change', '.schedule_every_type').on('change', '.schedule_every_type', function()
        {
            $('.schedule_every_type_weekly, .schedule_every_type_monthly, .schedule_every_type_seasonly, .schedule_every_type_yearly').hide();
            $('#schedule_every_type_' + $(this).val()).show();
        });
        //
        $(document).off('click', '.schedule_begin_by_date').on('click', '.schedule_begin_by_date', function()
        {
            $('.schedule_begin_by_date_value').focus();
        });
        // schedule_end_by_date
        var schedule_end_by_date_value = '.schedule_end_by_date_value';
        $(document).off('click', '.schedule_end_by_date').on('click', '.schedule_end_by_date', function()
        {
            $(schedule_end_by_date_value).prop('disabled', false);
            $(schedule_end_by_date_value).focus();
            $('.schedule_end_by_recur_value').prop('disabled', true);
        });
        //
        $(document).off('click', '.schedule_end_by_recur').on('click', '.schedule_end_by_recur', function()
        {
            $(schedule_end_by_date_value).prop('disabled', false);
            $(schedule_end_by_date_value).focus();
            $('.schedule_end_by_date_value').prop('disabled', true);
        });
        //
        $(document).off('click', '.schedule_end_never').on('click', '.schedule_end_never', function()
        {
            $('.schedule_end_by_date_value, .schedule_end_by_recur_value').prop('disabled', true);
        });
        //
        $(document).off('click', '.bnt_save').on('click', '.bnt_save', function()
        {
            general_deadline_from_date.val(general_deadline_from_date.val().nums_to_en());
            general_deadline_from_time.val(general_deadline_from_time.val().nums_to_en());
            general_deadline_to_date.val(general_deadline_to_date.val().nums_to_en());
            general_deadline_to_time.val(general_deadline_to_time.val().nums_to_en());
            general_deadline_to_day.val(general_deadline_to_day.val().nums_to_en());
            general_deadline_to_hourmin.val(general_deadline_to_hourmin.val().nums_to_en());
            is_apply = $(this).data('apply');
            $('.submit_form_task_integrate').click();
        });
        $(document).off('click', '.btn_close').on('click', '.btn_close', function()
        {
            $(this).parent().parent().find('.panel-heading .jsglyph-close').click();
        });
        $('.table_choices').DataTable
        ({
            columns:
            [
                {'title': 'ردیف'},
                {'title': 'شناسه'},
                {'title': 'موضوع'},
                {'title': 'عنوان'},
                {'title': 'ارجاع دهنده'},
                {'title': 'اهمیت'},
                {'title': 'فوریت'}/*,
                {'title': 'حذف', sortable: false}*/
            ],
            data: {!! $choices_datatable_data !!},
            scrollX: true,
            processing: false,
            serverSide: false
        });
    });
</script>
