<script>
    $(document).ready(function()
    {
        var stack_top_left = {"dir1": "down", "dir2": "left", "push": "top"};

        function print_ajax_error(text) {
            // Solid danger
            new PNotify({
                title: 'خطا',
                text: text,
                addclass: 'bg-danger stack-top-left',
                stack: stack_top_left
            });
        }

        function print_ajax_success_msg(text) {
            // Solid success
            new PNotify({
                title: 'تایید',
                text: text,
                addclass: 'bg-success stack-top-left',
                stack: stack_top_left
            });
        }

        $('.column_concat_get_list').select2({
            tags: true,
            // automatically creates tag when user hit space or comma:
            tokenSeparators: [",", " "],
            width: '100%'
        });

        $('.template_get_list').select2({
            tags: true,
            // automatically creates tag when user hit space or comma:
            tokenSeparators: [",", " "],
            width: '100%'
        });

        $('.template').select2({
            tags: true,
            // automatically creates tag when user hit space or comma:
            tokenSeparators: [",", " "],
            width: '100%'
        });

        $(document).off('click', '.btn_add_subject_settings').on('click', '.btn_add_subject_settings', function ()
        {
            $("#form_subject_submit").click();
        });

        var constraints_form_subject = {
            url: {
                presence: {message: '^<strong>آدرس الزامی است.</strong>'},
            },
            report: {
                presence: {message: '^<strong>کد گزارش الزامی است.</strong>'},
            },
            token: {
                presence: {message: '^<strong>توکن الزامی است.</strong>'},
            },
            column: {
                presence: {message: '^<strong>شماره فیلد الزامی است.</strong>'},
            },
            url_get_list: {
                presence: {message: '^<strong>آدرس الزامی است.</strong>'},
            },
            token_get_list: {
                presence: {message: '^<strong>توکن الزامی است.</strong>'},
            },
            report_get_list: {
                presence: {message: '^<strong>کد گزارش الزامی است.</strong>'},
            },
            column_get_list: {
                presence: {message: '^<strong>شماره فیلد الزامی است.</strong>'},
            },
            column_concat_get_list: {
                presence: {message: '^<strong>ترکیب شماره فیلد ها الزامی است.</strong>'},
            },
        } ;
        var form_subject = document.querySelector("#form_subject");
        init_validatejs(form_subject, constraints_form_subject, add_subject_setting);
        function add_subject_setting (formElement)
        {
            var formData = new FormData(formElement);
            $.ajax
            ({
                type: 'post',
                url: '{{ route('ltm.backend.subjects.add_subject_setting')}}',
                dataType: 'json',
                data: formData,
                success: function(result)
                {
                    $('#form_subject .total_loader').remove() ;
                    if (result.success == true) {
                        print_ajax_success_msg(result.message);
                        $('.jsglyph-close').click();
                    }
                    else {
                        $.each(result.error,function (index,value) {
                            print_ajax_error(value);
                        });
                    }
                }
            });
        }
    });
</script>
