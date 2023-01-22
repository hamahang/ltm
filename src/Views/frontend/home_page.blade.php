@extends('laravel_task_manager::layouts.frontend.bootstrap_v4.master')
@section('inline_css')
    <style>
        .form-group{
            margin-bottom: 0;
        }
        .messages {
            font-size: 12px;
            font-weight: bolder;
            height: 38px;
        }
        .has-success .help-block,
        .has-success .control-label,
        .has-success .radio,
        .has-success .checkbox,
        .has-success .radio-inline,
        .has-success .checkbox-inline,
        .has-success.radio label,
        .has-success.checkbox label,
        .has-success.radio-inline label,
        .has-success.checkbox-inline label {
            color: #3c763d;
        }

        .has-success .form-control {
            border-color: #3c763d;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .has-success .form-control:focus {
            border-color: #2b542c;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #67b168;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #67b168;
        }

        .has-success .input-group-addon {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #3c763d;
        }

        .has-success .form-control-feedback {
            color: #3c763d;
        }

        .has-warning .help-block,
        .has-warning .control-label,
        .has-warning .radio,
        .has-warning .checkbox,
        .has-warning .radio-inline,
        .has-warning .checkbox-inline,
        .has-warning.radio label,
        .has-warning.checkbox label,
        .has-warning.radio-inline label,
        .has-warning.checkbox-inline label {
            color: #8a6d3b;
        }

        .has-warning .form-control {
            border-color: #8a6d3b;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .has-warning .form-control:focus {
            border-color: #66512c;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #c0a16b;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #c0a16b;
        }

        .has-warning .input-group-addon {
            color: #8a6d3b;
            background-color: #fcf8e3;
            border-color: #8a6d3b;
        }

        .has-warning .form-control-feedback {
            color: #8a6d3b;
        }

        .has-error .help-block,
        .has-error .control-label,
        .has-error .col-form-label,
        .has-error .radio,
        .has-error .checkbox,
        .has-error .radio-inline,
        .has-error .checkbox-inline,
        .has-error.radio label,
        .has-error.checkbox label,
        .has-error.radio-inline label,
        .has-error.checkbox-inline label {
            color: #a94442;
        }

        .has-error .form-control {
            border-color: #a94442;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        }

        .has-error .form-control:focus {
            border-color: #843534;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
        }

        .has-error .input-group-addon {
            color: #a94442;
            background-color: #f2dede;
            border-color: #a94442;
        }

        .has-error .form-control-feedback {
            color: #a94442;
        }

        .has-feedback label ~ .form-control-feedback {
            top: 25px;
        }

        .has-feedback label.sr-only ~ .form-control-feedback {
            top: 0;
        }

        .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: #737373;
        }
    </style>
@stop
@section('content')
    <div class="space-20"></div>
    <div class="row">
        <div class="col-lg-4 order-lg-1">
            <div class="panel-body" style="background-color: rgba(255,255,255,0.3); border: 1px solid white;">
                <div class="container">
                    <div class="space-10"></div>
                    <div id="login_form_area">
                        <div class="text-center" style="color: red; margin-bottom: 3px;">
                            <strong id="auth_error_message"></strong>
                        </div>
                        <div class="text-center" style="color: red; margin-bottom: 3px;">
                            <strong id="email_validation_error_message"></strong>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form id="login_form_id" name="login_form_name" action="" novalidate>
                                    <div class="form-group row fg_username">
                                        <label class="col-sm-4 col-form-label" for="username">
                                            <span class="more_info"></span>
                                            <span class="red_star">*</span>
                                            <span class="label_title">نام کاربری :</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="username" name="username" class="field_username form-control ltr" tab="1">
                                            <div class="col-sm-12 messages"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row fg_password">
                                        <label class="col-sm-4 col-form-label" for="password">
                                            <span class="password"></span>
                                            <span class="red_star">*</span>
                                            <span class="label_title">رمزعبور :</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="password" id="password" name="password" class="field_password form-control ltr" tab="2">
                                            <div class="col-sm-12 messages"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row fg_captcha_code">
                                        <label class="col-sm-4 col-form-label" for="login_captcha_code">
                                            <span class="more_info"></span>
                                            <span class="red_star">*</span>
                                            <span class="label_title">کد امنیتی :</span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" maxlength="6" id="login_captcha_code" name="login_captcha_code" class="field_login_captcha_code form-control ltr" placeholder="" tab="3" autocomplete="off">
                                            <div class="space-2"></div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-flat fas fa-sync captcha_refresh" type="button"></button>
                                                </div>
                                                <div class="form-control" style="padding: 2px; background: #888;">
                                                    <img style="height: 40px; width: 100%; border-radius: 3px 0 0 3px;" class="captcha_image" src="{{ route('captcha', 'login') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 messages"></div>
                                        </div>
                                    </div>
                                    <button id="btn_login" type="submit" value="login" class="btn bg-info text-white btn-block login">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <span>ورود به سامانه</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="hr hr-4"></div>
                        <div class="row">
                            <div class="col-12">
                                <button id="btn_register" type="button" value="login" class="btn btn-success btn-block btn-flat">
                                    <i class="fas fa-user-plus"></i>
                                    <span>ثبت نام در سامانه</span>
                                </button>
                            </div>
                        </div>
                        <div class="hr hr-4"></div>
                        <div class="row">
                            <div class="col-12">
                                <button id="btn_recovery_password" type="button" value="login" class="btn btn-default btn-block btn-flat">
                                    <i class="fas fa-redo-alt"></i>
                                    <span>بازیابی رمز عبور</span>
                                </button>
                            </div>
                        </div>
                        <div class="space-10"></div>
                    </div>
                    <div class="space-10"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 order-lg-0 text-justify">
            <div class="panel-body">
                <h5>
                    <span>  موضوع فعالیت </span>
                    <span style="text-decoration: underline;">
                        <a title="صندوق ضمانت سرمایه گذاری صنایع کوچک" href="http://sif.ir" target="_blank">صندوق ضمانت سرمایه گذاری صنایع کوچک</a>
                    </span>
                </h5>
                <p>کمک به توسعه صنایع کوچک از طریق تضمین تا سقف ۳۰ میلیارد ریال و تا ۵۰% تخفیف کارمزد نسبت به بانک ها در موارد زیر می باشد :</p>
                <ul>
                    <li>ضمانت نامه پیش پرداخت</li>
                    <li>ضمانت نامه حسن انجام تعهدات</li>
                    <li>ضمانت نامه شرکت در مناقصه و مزایده</li>
                    <li>ضمانت نامه اعتبار خریدار (خرید مواد اولیه)</li>
                    <li>ضمانت نامه استرداد کسور وجه الضمان/ بیمه / مالیات</li>
                    <li>ضمانت نامه اعتباری برای تسهیلات بانکی سرمایه ثابت و در گردش</li>
                </ul>
                <p>- <span style="font-size: 16px;"><strong>قبل از شروع ثبت نام حتما <a title="اهم شرایط و ضوابط" href="http://zemanat.sif.ir/download/get_files/MTQxNDM%3D" target="_blank">اهم شرایط و ضوابط</a>&nbsp;، <a
                                    title="فرم&zwnj;های مورد نیاز" href="http://zemanat.sif.ir/download/get_files/MTQ4NDI%3D" target="_blank">فرم&zwnj;های مورد نیاز</a>&nbsp;و&nbsp;<a
                                    href="http://zemanat.sif.ir/download/get_files/NTc4NA%3D%3D" target="_blank">راهنمای متقاضیان</a>&nbsp;را مطالعه فرمایید.</strong></span></p>
                <p>&nbsp;- در صورت وجود هر گونه سوال و ابهام در ساعات اداری با شماره&nbsp;تلفن 88553363-021 داخلی های&nbsp;222 و 215 تماس حاصل فرمایید.</p>
                <p>- شماره تلفن نماینده صندوق در استان محل فعالیت خود را از&nbsp;<a title="تلفن نمایندگان استانی" href="http://zemanat.sif.ir/download/get_files/MTMxMjM%3D" target="_blank">اینجا</a>&nbsp;بیابید.</p>
            </div>
        </div>
        <div class="clearfixed"></div>
        <div class="space-10"></div>
    </div>
@stop
@section('footer_inline_js')
    <script>
        $(document).off('click', '#btn_register');
        $(document).on('click', '#btn_register', function () {
            window.location = '{{route('auth.sso.register')}}';
        });

        $(document).off('click', '#btn_recovery_password');
        $(document).on('click', '#btn_recovery_password', function () {
            window.location = '{{route('auth.sso.password.recovery')}}';
        });

        $(document).off('click', '.captcha_refresh');
        $(document).on("click", ".captcha_refresh", function () {
            captcha_refresh();
        });
        function captcha_refresh() {
            $('.captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
        }

        var validate_login = {
            username: {
                presence: {message: '^<strong>رمزعبور الزامی است.</strong>'}
            },
            password: {
                presence: {message: '^<strong>رمزعبور الزامی است.</strong>'}
            },
            login_captcha_code: {
                presence: {message: '^<strong>کد امنیتی الزامی است.</strong>'}
            }
        };
        var form_login = document.querySelector("#login_form_id");
        function Login(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('auth.sso.login_user')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success == true) {
                        document.location = data.href
                    }
                    else {
                        captcha_refresh();
                        $('#login_form_id .total_loader').remove();
                        showErrors(formElement, data.errors);
                    }
                }
            });
        }
        init_validatejs(form_login, validate_login, Login, 'login_form_id');
    </script>
@stop