<script>
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
            addclass: 'bg-success stack-top-left',index_inline_js
            stack: stack_top_left
        });
    }
    window.GridData = "";
    $(function () {
        ajax_url = '{!! route('ltm.backend.users.get_users') !!}';
        columns = [
            {
                title: "ردیف",
                width: "10px",
                data: "id",
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'first_name', name: 'first_name', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.first_name != null)
                        return full.first_name;
                    else
                        return '';
                }
            },
            {
                data: 'last_name', name: 'last_name', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.last_name != null)
                        return full.last_name;
                    else
                        return '';
                }
            },
            {
                data: 'username', name: 'username', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.username != null)
                        return full.username;
                    else
                        return '';
                }
            },
            {
                data: 'user_type', name: 'user_type', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.user_type != null)
                        return full.user_type;
                    else
                        return '';
                }
            },
            {
                data: 'avatar_file_manager', name: 'avatar_file_manager', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.avatar_file_manager != null)
                        return full.avatar_file_manager;
                    else
                        return '';
                }
            },
            {
                data: 'email', name: 'email', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.email != null)
                        return full.email;
                    else
                        return '';
                }
            },
            {
                data: 'melli_code', name: 'melli_code', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.melli_code != null)
                        return full.melli_code;
                    else
                        return '';
                }
            },
            {
                data: 'mobile', name: 'mobile', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.mobile != null)
                        return full.mobile;
                    else
                        return '';
                }
            },
            {
                data: 'address', name: 'address', className: "text-center",
                mRender: function (data, type, full) {
                    if (full.address != null)
                        return full.address;
                    else
                        return '';
                }
            },
            {
                data: 'action', name: 'action',
                mRender: function (data, type, full) {
                    var result = '';
                    result += '<button type="button" class="btn btn-xs bg-danger-800 fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full.id + '" ></button> ';
                    result += '<button type="button" class="btn btn-xs bg-warning-400 fa fa-reply btn_grid_item_edit" data-grid_item_id="' + full.id + '"></button>';
                    return result;
                }
            },
        ];
        dataTablesGrid('#GridData', 'GridData', ajax_url, columns, null, null, true, '35vh', true);
    });

   $(document).off('click', '.btn_grid_item_edit').on('click', '.btn_grid_item_edit', function () {
       var item_id = $(this).data('grid_item_id');
        $.ajax({
            type: 'post',
            url: '{{ route('ltm.backend.users.view_user')}}',
            dataType: 'json',
            data:{item_id:item_id},
            success: function (result) {
                if (result.success == true) {
                    console.log(result);
                    $('#form_edit_user').find('.user_type').val();
                    $('#form_edit_user').find('.username').val(result.user.username);
                    $('#form_edit_user').find('.email').val(result.user.email);
                    $('#form_edit_user').find('.melli_code').val(result.user.melli_code);
                    $('#form_edit_user').find('.first_name ').val(result.user.first_name);
                    $('#form_edit_user').find('.last_name').val(result.user.last_name);
                    $('#form_edit_user').find('.mobile').val(result.user.mobile);
                    $('#form_edit_user').find('.address').val(result.user.address);
                    $('#form_edit_user').find('.postal_code').val(result.user.postal_code);
                    $('#form_edit_user').find('.is_active').val(result.user.is_active);

                    $('#form_edit_user').find('.item_id').val(result.user.id);

                    activaTab("users_edit_tab");
                    window.GridData.ajax.reload();
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                }
            }
        });
    });

   function activaTab(tab){
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };

   var constraints = {
        first_name: {
            presence: {message: '^<strong>وارد کردن نام الزامی است.</strong>'},
            only_persian: {message: '^<strong>نام باید حتما فارسی باشد.</strong>'},
            length: {minimum: 2, message: '^<strong>نام نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام نمی‌تواند بیشتر از 4 کاراکتر باشد.</strong>'}
        },
        last_name: {
            presence: {message: '^<strong>وارد کردن نام خانوادگی الزامی است.</strong>'},
            only_persian: {message: '^<strong>نام خانوادگی باید حتما فارسی باشد.</strong>'},
            length: {minimum: 2, message: '^<strong>نام خانوادگی نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام خانوادگی نمی‌تواند بیشتر از 4 کاراکتر باشد.</strong>'}
        },
        melli_code: {
            presence: {message: '^<strong>وارد کردن کدملی الزامی است.</strong>'},
            codeMelli: {message: '^<strong>کدملی وارد شده معتبر نمی باشد.</strong>'},
            length: {maximum: 10, message: '^<strong>کد ملی نمی‌تواند بیشتر از 10 کاراکتر باشد.</strong>'}
        },
        mobile: {
            presence: {message: '^<strong>وارد کردن شماره همراه الزامی است.</strong>'},
            iranMobileNumber: {message: '^<strong>شماره همراه وارد شده صحیح نمی باشد.</strong>'},
            length: {maximum: 11, message: '^<strong>شماره همراه نمی‌تواند بیشتر از 11 کاراکتر باشد.</strong>'}
        },
        postal_code: {
            presence: {message: '^<strong>وارد کردن کد پستی الزامی است.</strong>'},
            length: {maximum: 10, message: '^<strong>کد پستی نمی‌تواند بیشتر از 10 کاراکتر باشد.</strong>'}
        },
        address: {
            presence: {message: '^<strong>وارد کردن آدرس الزامی است.</strong>'},
            length: {maximum: 255, message: '^<strong>آدرس نمی‌تواند بیشتر از 255 کاراکتر باشد.</strong>'}
        },
        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
        username: {
            username: {message: ''}
        },
        password: {
            presence: {message: '^<strong>وارد کردن رمزعبور الزامی است.</strong>'},
            //only_english: {message: '^<strong>رمزعبور باید حتما انگلیسی باشد.</strong>'},
            length: {minimum: 6, message: '^<strong>کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.</strong>'}
        },
        password_confirmation: {
            presence: {message: '^<strong>وارد کردن تکرار کلمه عبور الزامی است.</strong>'},
            length: {minimum: 6, message: '^<strong>تکرار کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.</strong>'},
            equality: {
                attribute: "password",
                message: '^<strong>تکرار رمز عبور با رمز عبور وارد شده یکسان نیست.</strong>',
                comparator: function (v1, v2) {
                    return JSON.stringify(v1) === JSON.stringify(v2);
                }
            }
        }
    };
    var form = document.querySelector("#form_created_user");
    function func_ajax_save_user(formElement) {
        //var l = Ladda.create(this);
       // l.start();
        var formData = new FormData(formElement);
        $.ajax({
            type: 'post',
            url: '{{ route('ltm.backend.users.save_user')}}',
            dataType: 'json',
            data: $('#form_created_user').serialize(),
            success: function (result) {
                if (result.success == true) {
                    //print_ajax_success_msg(result.message);
                    showMessages(result.message, 'form_message_box_create', 'success', formElement);
                    window.GridData.ajax.reload();
                    var elmnt = document.getElementById("form_message_box_create");
                    elmnt.scrollIntoView();
                    //l.stop();
                }
                else {
                    /*$.each(result.error, function (index, value) {
                        print_ajax_error(value);
                    });*/
                    if(result.message){
                        console.log(result.messag);
                        showMessages(result.message, 'form_message_box_create', 'error', formElement);
                    }
                    if(result.error){
                        showErrors(formElement, result.error);
                    }
                    var elmnt = document.getElementById("form_message_box_create");
                    elmnt.scrollIntoView();
                    //l.stop();
                }
            }
        });
    }
    init_validatejs(form, constraints, func_ajax_save_user,'#form_created_user');

    var constraints_edit = {
        first_name: {
            presence: {message: '^<strong>وارد کردن نام الزامی است.</strong>'},
            only_persian: {message: '^<strong>نام باید حتما فارسی باشد.</strong>'},
            length: {minimum: 2, message: '^<strong>نام نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام نمی‌تواند بیشتر از 4 کاراکتر باشد.</strong>'}
        },
        last_name: {
            presence: {message: '^<strong>وارد کردن نام خانوادگی الزامی است.</strong>'},
            only_persian: {message: '^<strong>نام خانوادگی باید حتما فارسی باشد.</strong>'},
            length: {minimum: 2, message: '^<strong>نام خانوادگی نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام خانوادگی نمی‌تواند بیشتر از 4 کاراکتر باشد.</strong>'}
        },
        melli_code: {
            presence: {message: '^<strong>وارد کردن کدملی الزامی است.</strong>'},
            codeMelli: {message: '^<strong>کدملی وارد شده معتبر نمی باشد.</strong>'},
            length: {maximum: 10, message: '^<strong>کد ملی نمی‌تواند بیشتر از 10 کاراکتر باشد.</strong>'}
        },
        mobile: {
            presence: {message: '^<strong>وارد کردن شماره همراه الزامی است.</strong>'},
            iranMobileNumber: {message: '^<strong>شماره همراه وارد شده صحیح نمی باشد.</strong>'},
            length: {maximum: 11, message: '^<strong>شماره همراه نمی‌تواند بیشتر از 11 کاراکتر باشد.</strong>'}
        },
        postal_code: {
            presence: {message: '^<strong>وارد کردن کد پستی الزامی است.</strong>'},
            length: {maximum: 10, message: '^<strong>کد پستی نمی‌تواند بیشتر از 10 کاراکتر باشد.</strong>'}
        },
        address: {
            presence: {message: '^<strong>وارد کردن آدرس الزامی است.</strong>'},
            length: {maximum: 255, message: '^<strong>آدرس نمی‌تواند بیشتر از 255 کاراکتر باشد.</strong>'}
        },
        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
        username: {
            username: {message: ''}
        },
    };
    var formEdit = document.querySelector("#form_edit_user");
    function func_ajax_edit_user(formElement) {
        //var l = Ladda.create(this);
        // l.start();
        var formData = new FormData(formElement);
        $.ajax({
            type: 'post',
            url: '{{ route('ltm.backend.users.edit_user')}}',
            dataType: 'json',
            data: $('#form_edit_user').serialize(),
            success: function (result) {
                if (result.success == true) {
                    //print_ajax_success_msg(result.message);
                    showMessages(result.message, 'form_message_box_edit', 'success', formElement);
                    window.GridData.ajax.reload();
                    var elmnt = document.getElementById("form_message_box_edit");
                    elmnt.scrollIntoView();
                    //l.stop();
                }
                else {
                    /*$.each(result.error, function (index, value) {
                     print_ajax_error(value);
                     });*/
                    showMessages(result.message, 'form_message_box_edit', 'error', formElement);
                    showErrors(formElement, result.error);
                    var elmnt = document.getElementById("form_message_box_edit");
                    elmnt.scrollIntoView();
                    //l.stop();
                }
            }
        });
    }
    init_validatejs(formEdit, constraints_edit, func_ajax_edit_user,'#form_edit_user');
</script>