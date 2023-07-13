<script src="{{asset('vendor/laravel_task_manager/build/multi_upload_image.min.js')}}"></script>
<script>
    window.attachs = new Vue({
        el: '#attachs',
    });
    String.prototype.nums_to_en = function()
    {
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(fa[i], en[i]);
        }
        return r;
    };

    var general_deadline = '.general_deadline';
    var general_deadline_from_date = $('.general_deadline_from_date');
    var general_deadline_from_time = $('.general_deadline_from_time');
    var general_deadline_to_date = $('.general_deadline_to_date');
    var general_deadline_to_time = $('.general_deadline_to_time');
    var general_deadline_to_day = $('.general_deadline_to_day');
    var general_deadline_to_hourmin = $('.general_deadline_to_hourmin');
    var is_apply = false;
    var form = document.querySelector('#form_task_add');
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
            'general_users[]':
                {
                    presence: {message: '^<strong>مسئول یا مسئولین الزامی است</strong>'}
                }/*,
        general_file_no:
        {
            presence: {message: '^<strong>شماره پرونده الزامی است</strong>'}
        },
        setting_action_do:
        {
            presence: {message: '^<strong>فرم انجام زبانه‌های اقدام الزامی است</strong>'}
        },
        setting_action_transfer:
        {
            presence: {message: '^<strong>فرم ارجاع زبانه‌های اقدام الزامی است</strong>'}
        },
        setting_action_reject:
        {
            presence: {message: '^<strong>فرم نپذیرفتن زبانه‌های اقدام الزامی است</strong>'}
        }*/
        };
    function task_add(formElement)
    {
        general_deadline_from_date.val(general_deadline_from_date.val().nums_to_en());
        general_deadline_from_time.val(general_deadline_from_time.val().nums_to_en());
        general_deadline_to_date.val(general_deadline_to_date.val().nums_to_en());
        general_deadline_to_time.val(general_deadline_to_time.val().nums_to_en());
        general_deadline_to_day.val(general_deadline_to_day.val().nums_to_en());
        general_deadline_to_hourmin.val(general_deadline_to_hourmin.val().nums_to_en());
        is_apply = $(this).data('apply');
        var formData = new FormData(formElement);
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.task.add')}}',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result)
            {
                console.log(result);
                if ('success' === result.status_type)
                {
                    $('#form_task_add .total_loader').remove();
                    if (result.success)
                    {
                        window.location.reload();
                        // parent.redirect_after_success(result.url);
                    }
                    else {
                        showMessages(result.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, result.errors);
                    }
                    //messageModal('success', 'افزودن وظیفه جدید', {0: result.message});
                } else
                {
                    showMessages(result.message, 'form_message_box', 'error', formElement);
                    showErrors(form, result.errors);
                    $('.total_loader').remove();
                    //messageModal('error', result.message.title, result.error);
                }
            }
        }).fail(function(result)
        {
            alert('خطای ' + result.statusText);
            $('.total_loader').remove();
        });
    }
    init_validatejs(form, constraints, task_add, '#form_task_add');
    //
    $(document).ready(function()
    {
        let assigners = JSON.parse(@json(json_encode($assigners))) ;

        assigners = assigners.map(function (item) {
            return {id:item.id,text:item.full_name}
        })
        init_select2_ajax('.general_subject_id', '{{ route('ltm.auto_complete.subjects') }}', true);
        init_select2_data('#general_users',assigners, false, true, true, false, 'انتخاب کاربر');
        init_select2_data('#general_transcripts_cc',assigners, false, true, true, false, 'انتخاب کاربر');
        init_select2_data('#general_transcripts_bcc',assigners, false, true, true, false, 'انتخاب کاربر');

        init_select2_ajax('.general_keywords', '{{ route('ltm.auto_complete.keywords') }}', true, true, true);
        init_select2_ajax('.setting_action_do_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        init_select2_ajax('.setting_action_transfer_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        init_select2_ajax('.setting_action_reject_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
        $('.general_file_no').select2();
        // datepickers
        $('.general_deadline_from_date, .general_deadline_to_date').pDatepicker({format: 'YYYY/MM/DD'});
        $('.general_deadline_from_time, .general_deadline_to_time, .general_deadline_to_hourmin').pDatepicker({format: 'HH:mm', onlyTimePicker: true});
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
                    $('.general_deadline_from_date').pDatepicker({format: 'YYYY/MM/DD'});
                    general_deadline_from_time.pDatepicker({format: 'HH:mm', onlyTimePicker: true});
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
            $('.submit_form_task_add').click();
        });
    });
    $(document).on('change', '.general_subject_id', function()
    {
        var subject_id = $(this).val();
        $.ajax
        ({
            type: 'POST',
            url: '{{ route('ltm.backend.subjects.test_get_data') }}',
            data: {subject_id: subject_id},
            dataType: 'json',
            success: function(data_res)
            {
                if ('1' == data_res.status)
                {
                    var options = '<option value="">بدون شماره پرونده</option>';
                    $.each(data_res.data, function(index, value)
                    {
                        options = options + '<option value="' + value.id + '">' + value.text + '</option>';
                    });
                    $('.general_file_no').html(options);
                } else
                {
                    $('.general_file_no').html('');
                }
            }
        });
    });
    function clear_form_elements(selector) {
        selector = selector || 'document';
        $(ele).find(':input').each(function () {
            switch (this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });

    }
</script>
