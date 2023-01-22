<script>
    $(document).ready(function () {
        create_send_setting_constraints = {} ;
        var setting_form_id = document.querySelector("#frm_send_notification_setting");
        init_validatejs(setting_form_id, create_send_setting_constraints, ajax_func_send_setting);

        function ajax_func_send_setting(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('ltm.backend.settings.store')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#frm_send_notification_setting .total_loader').remove();
                    if (data.success) {
                        init_pm_notify(('success',data.title, data.message));
                    }
                    else {
                        showMessages(data.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, data.errors);
                    }
                }
            });
        }

        //========================recive notify======================
        create_recive_setting_constraints = {} ;
        var setting_form_id = document.querySelector("#frm_recive_notification_setting");
        init_validatejs(setting_form_id, create_recive_setting_constraints, ajax_func_recive_setting);
        function ajax_func_recive_setting(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('ltm.backend.settings.store_recive')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#frm_recive_notification_setting .total_loader').remove();
                    if (data.success) {
                        init_pm_notify(('success',data.title, data.message));
                    }
                    else {
                        showMessages(data.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, data.errors);
                    }
                }
            });
        }
    });

    $(document).off('click', '.setting_email, .setting_sms, .setting_messaging').on('click', '.setting_email, .setting_sms, .setting_messaging', function()
    {
        $('.fg_' + $(this).attr('class')).toggle();
    });


</script>