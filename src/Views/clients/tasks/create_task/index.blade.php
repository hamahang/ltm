@extends(config('laravel_task_manager.task_master'))
@section(config('laravel_task_manager.task_master_yield_inline_style'))
    <style>
        .radio-inline,
        .checkbox-inline {
            padding-right: 20px !important;
            cursor: default;
        }

        .fg_general_deadline_2,
        .fg_general_deadline_3,
        .schedule_every_type_weekly,
        .schedule_every_type_monthly,
        .schedule_every_type_seasonly,
        .schedule_every_type_yearly,
        .fg_setting_email,
        .fg_setting_sms,
        .fg_setting_messaging {
            display: none;
        }

        div.empty:empty {
            display: none;
        }
    </style>
@endsection
@section(config('laravel_task_manager.task_master_yield_content'))
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="tabbable">
                        @php
                            $week_days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', ];
                            $month_weeks = ['اولین', 'دومین', 'سومین', 'چهارمین', 'آخرین', ];
                            $seasons = ['بهار', 'تابستان', 'پاییز', 'زمستان', ];
                            $year_months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند ', ];
                        @endphp
                        <div id="form_message_box" class="form_message_area"></div>
                        <form class="form-horizontal form_task_add" id="form_task_add" name="form_task_add">
                            <!-- tabs: start -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">تعریف</a></li>
                                <li><a data-toggle="tab" href="#setting">تنظیمات</a></li>
                                <li><a data-toggle="tab" href="#attachs">پیوست&zwnj;ها</a></li>
                                <li><a data-toggle="tab" href="#schedule">زمانبندی</a></li>
                                <li><a data-toggle="tab" href="#resources">منابع</a></li>
                                <li><a data-toggle="tab" href="#rels">روابط</a></li>
                            </ul>
                            <!-- tabs: end / content: start -->
                            <div class="tab-content">
                                <!-- general: start -->
                                <div class="tab-pane fade in active" id="general">
                                    <!-- [field_group]: start -->
                                    <div class="form-group" style="margin-bottom: 0;">
                                        <label class="col-sm-2 control-label" for="fg_general_type">
                                            <span>نوع</span>
                                            <span class="red_star">*</span>
                                        </label>
                                        <!-- general_type: start -->
                                        <div class="col-md-4 form-group fg_general_type">
                                            <div class="radio-inline"><label for="general_type_0"><input type="radio" id="general_type_0" name="general_type" value="0" checked/>رویداد</label></div>
                                            <div class="radio-inline"><label for="general_type_1"><input type="radio" id="general_type_1" name="general_type" value="1"/>فعالیت</label></div>
                                            <div class="messages"></div>
                                        </div>
                                        <!-- general_type: end / general_importance: start -->
                                        <div class="col-md-3 form-group fg_general_importance">
                                            <div class="radio-inline"><label for="general_importance_0"><input type="radio" id="general_importance_0" name="general_importance" value="0" checked/>غیر مهم</label></div>
                                            <div class="radio-inline"><label for="general_importance_1"><input type="radio" id="general_importance_1" name="general_importance" value="1"/>مهم</label></div>
                                            <div class="messages"></div>
                                        </div>
                                        <!-- general_importance: end / general_immediate: start -->
                                        <div class="col-md-3 form-group fg_general_immediate">
                                            <div class="radio-inline"><label for="general_immediate_0"><input type="radio" id="general_immediate_0" name="general_immediate" value="0" checked/>غیر فوری</label></div>
                                            <div class="radio-inline"><label for="general_immediate_1"><input type="radio" id="general_immediate_1" name="general_immediate" value="1"/>فوری</label></div>
                                            <div class="messages"></div>
                                        </div>
                                        <!-- general_immediate: end -->
                                    </div>
                                    <!-- [field_group]: end / general_title: start -->
                                    <div class="form-group fg_general_title">
                                        <label class="col-sm-2 control-label" for="general_title">
                                            <span>عنوان</span>
                                            <span class="red_star">*</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="general_title" name="general_title"/>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <!-- general_title: end / general_subject_id: start -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <label class="col-sm-10 control-label">
                                            <span style="color: #ffc50d"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                            <span style="    color: #989898;">جهت مشاهده کلیه موضوعات قابل انتخاب میتوانید از "..." استفاده نمائید .</span>
                                        </label>
                                        <label class="col-sm-2 control-label" for="general_subject_id">
                                            <span>موضوع</span>
                                            <span class="red_star">*</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <select type="text" class="form-control general_subject_id" id="general_subject_id" name="general_subject_id"></select>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <!-- general_subject_id: end / general_description: start -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="general_description">
                                            <span>توضیحات</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea type="text" class="form-control" id="general_description" name="general_description" rows="5"></textarea>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <!-- general_description: end / general_users: start -->
                                    <div class="form-group fg_general_users">
                                        <label class="col-sm-2 control-label"></label>
                                        <label class="col-sm-10 control-label">
                                            <span style="color: #ffc50d"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                            <span style="color: #989898;">جهت مشاهده کلیه مسئولین قابل انتخاب میتوانید از "..." استفاده نمائید .</span>
                                        </label>
                                        <label class="col-sm-2 control-label" for="general_users">
                                            <span>مسئولین</span>
                                            <span class="red_star">*</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                                        <i class="fa fa-child jsPanel-s" data-href="" style="cursor: pointer; font-size: 18px;"></i>
                                                    </span>
                                                    <span style="padding-right: 5px;">0</span>
                                                </div>
                                                <select class="general_users" id="general_users" name="general_users[]" multiple="multiple">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <!-- general_users: end / general_transcripts_cc: start -->
                                    <div class="form-group fg_general_transcripts_cc">
                                        <label class="col-sm-2 control-label" for="general_transcripts_cc">
                                            <span>رونوشت عمومی</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                            <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                <i class="fa fa-child jsPanel-s" data-href="" style="cursor: pointer; font-size: 18px;"></i>
                            </span>
                                                    <span style="padding-right: 5px;">0</span>
                                                </div>
                                                <select class="form-control general_transcripts_cc" id="general_transcripts_cc" name="general_transcripts_cc[]" multiple>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <!-- general_transcripts_cc: end / general_transcripts_bcc: start -->
                                    <div class="form-group fg_general_transcripts_bcc">
                                        <label class="col-sm-2 control-label" for="general_transcripts_bcc">
                                            <span>رونوشت خصوصی</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                            <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                <i class="fa fa-child jsPanel-s" data-href="" style="cursor: pointer; font-size: 18px;"></i>
                            </span>
                                                    <span style="padding-right: 5px;">0</span>
                                                </div>
                                                <select class="form-control general_transcripts_bcc" id="general_transcripts_bcc" name="general_transcripts_bcc[]" multiple>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <!-- general_transcripts_bcc: end / general_keywords: start -->
                                    <div class="form-group fg_general_keywords">
                                        <label class="col-sm-2 control-label" for="general_keywords">
                                            <span>کلیدواژه&zwnj;ها</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <select class="form-control general_keywords" id="general_keywords" name="general_keywords[]" multiple></select>
                                        </div>
                                    </div>
                                    <!-- general_keywords: end / general_file_no: start -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="general_file_no">
                                            <span>شماره پرونده</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <select class="form-control general_file_no" id="general_file_no" name="general_file_no">
                                                <option value="">بدون شماره پرونده</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- general_file_no: end / general_deadline: start -->
                                    <div class="form-group general_deadline">
                                        <label class="col-sm-2 control-label" for="general_deadline">
                                            <span>مهلت انجام</span>
                                            <span class="red_star">*</span>
                                        </label>
                                        <div class="col-md-10">
                                            <div class="radio-inline"><label for="general_deadline_1"><input type="radio" class="general_deadline" id="general_deadline_1" name="general_deadline" value="1" checked/>آنی</label></div>
                                            <div class="radio-inline"><label for="general_deadline_2"><input type="radio" class="general_deadline" id="general_deadline_2" name="general_deadline" value="2"/>در زمان مقرر</label></div>
                                            <div class="messages"></div>
                                        </div>
                                    </div>
                                    <!-- general_deadline: end / general_deadline_from: start -->
                                    <div class="form-group custom_group_general_deadline_from" style="display: none;">
                                        <label class="col-sm-1 col-sm-offset-3 control-label" for="general_deadline_from">
                                            <span>از</span>
                                        </label>
                                        <div class="col-sm-2">
                                            <select class="form-control general_deadline_from" id="general_deadline_from" name="general_deadline_from">
                                                <option value="1">هم اکنون</option>
                                                <option value="2">زمان مقرر</option>
                                            </select>
                                        </div>
                                        <div class="fg_general_deadline_from_datetime" style="display: none;">
                                            <label class="col-sm-1 control-label" for="general_deadline_from_date">تاریخ</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control general_deadline_from_date" id="general_deadline_from_date" name="general_deadline_from_date" readonly="readonly"/>
                                            </div>
                                            <label class="col-sm-1 col-sm-offset-1 control-label" for="general_deadline_from_time">ساعت</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control general_deadline_from_time" id="general_deadline_from_time" name="general_deadline_from_time" readonly="readonly"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- [field_group]: start -->
                                    <div class="form-group custom_group_general_deadline_to" style="display: none;">
                                        <label class="col-sm-1 col-sm-offset-3 control-label" for="general_deadline_to">تا</label>
                                        <div class="col-sm-2">
                                            <select class="form-control general_deadline_to" id="general_deadline_to" name="general_deadline_to">
                                                <option value="1">مدت</option>
                                                <option value="2">زمان مقرر</option>
                                            </select>
                                        </div>
                                        <div class="fg_general_deadline_to_datetime" style="display: none;">
                                            <label class="col-sm-1 control-label" for="general_deadline_to_date">
                                                <span>تاریخ</span>
                                            </label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control general_deadline_to_date" id="general_deadline_to_date" name="general_deadline_to_date" readonly="readonly"/>
                                            </div>
                                            <label class="col-sm-1 col-sm-offset-1 control-label" for="general_deadline_to_time">
                                                <span>ساعت</span>
                                            </label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control general_deadline_to_time" id="general_deadline_to_time" name="general_deadline_to_time" readonly="readonly"/>
                                            </div>
                                        </div>
                                        <div class="fg_general_deadline_to_duration">
                                            <div class="col-sm-1 col-sm-offset-1">
                                                <input type="number" class="form-control general_deadline_to_day" id="general_deadline_to_day" name="general_deadline_to_day" value="1"/>
                                            </div>
                                            <label class="col-sm-1 control-label" for="general_deadline_to_day">
                                                <span>روز</span>
                                            </label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control general_deadline_to_hourmin" id="general_deadline_to_hourmin" name="general_deadline_to_hourmin" value="00:00" readonly="readonly"/>
                                            </div>
                                            <label class="col-sm-2 control-label" for="general_deadline_to_hourmin">
                                                <span>ساعت</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- [field_group]: end -->
                                </div>
                                <!-- general: end / setting: schedule -->
                                <div class="tab-pane fade" id="setting">
                                    <!-- setting_action: start -->
                                    <div class="well">
                                        <fieldset>
                                            <legend>تنظیمات فرم‌های زبانه‌های اقدام</legend>
                                            <!-- setting_email: start -->
                                            <div class="form-group fg_setting_action_do_form_id">
                                                <label class="col-sm-2 control-label" for="setting_action_do_form_id">
                                                    <span>فرم انجام</span>
                                                    <span class="red_star"></span>
                                                </label>
                                                <div class="col-sm-10">
                                                    <select type="text" class="form-control setting_action_do_form_id" id="setting_action_do_form_id" name="setting_action_do_form_id"></select>
                                                    <div class="messages"></div>
                                                </div>
                                            </div>
                                            <div class="form-group fg_setting_action_transfer_form_id">
                                                <label class="col-sm-2 control-label" for="setting_action_transfer_form_id">
                                                    <span>فرم ارجاع</span>
                                                    <span class="red_star"></span>
                                                </label>
                                                <div class="col-sm-10">
                                                    <select type="text" class="form-control setting_action_transfer_form_id" id="setting_action_transfer_form_id" name="setting_action_transfer_form_id"></select>
                                                    <div class="messages"></div>
                                                </div>
                                            </div>
                                            <div class="form-group fg_setting_action_reject_form_id">
                                                <label class="col-sm-2 control-label" for="setting_action_reject_form_id">
                                                    <span>فرم نپذیرفتن</span>
                                                    <span class="red_star"></span>
                                                </label>
                                                <div class="col-sm-10">
                                                    <select type="text" class="form-control setting_action_reject_form_id" id="setting_action_reject_form_id" name="setting_action_reject_form_id"></select>
                                                    <div class="messages"></div>
                                                </div>
                                            </div>
                                            <!-- setting_messaging: end -->
                                        </fieldset>
                                    </div>
                                    <br/>
                                    <!-- action: end / messaging: start -->
                                    <div class="well">
                                        <fieldset>
                                            <legend>تنظیمات اطلاع رسانی</legend>
                                            <!-- setting_email: start -->
                                            <div class="form-group">
                                                <div class="checkbox-inline col-sm-2">
                                                    <label>
                                                        <input type="checkbox" class="setting_email" id="setting_email" name="setting_email[]" value="is_active">
                                                        <span>ایمیل</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 fg_setting_email">
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_email_users" name="setting_email[]" value="users">
                                                            <span>مسئولین</span>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_email_transcripts" name="setting_email[]" value="transcripts">
                                                            <span>رونوشت گیرندگان</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- setting_email: end / setting_sms: start -->
                                            <div class="form-group">
                                                <div class="checkbox-inline col-sm-2">
                                                    <label>
                                                        <input type="checkbox" class="setting_sms" id="setting_sms" name="setting_sms[]" value="is_active">
                                                        <span>پیامک</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 fg_setting_sms">
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_sms_users" name="setting_sms[]" value="users">
                                                            <span>مسئولین</span>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_sms_transcripts" name="setting_sms[]" value="transcripts">
                                                            <span>رونوشت گیرندگان</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- setting_sms: end / setting_messaging: start -->
                                            <div class="form-group">
                                                <div class="checkbox-inline col-sm-2">
                                                    <label>
                                                        <input type="checkbox" class="setting_messaging" id="setting_messaging" name="setting_messaging[]" value="is_active">
                                                        <span>پیام رسان</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-10 fg_setting_messaging">
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_messaging_users" name="setting_messaging[]" value="users">
                                                            <span>مسئولین</span>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="" id="setting_messaging_transcripts" name="setting_messaging[]" value="transcripts">
                                                            <span>رونوشت گیرندگان</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- setting_messaging: end -->
                                        </fieldset>
                                    </div>
                                    <br/>
                                    <!-- messaging: end / setting_end_on_assigner_accept: start -->
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="" name="setting_end_on_assigner_accept" id="setting_end_on_assigner_accept" checked="checked">
                                            <span>پایان یافتن با اعلان واگذار کننده</span>
                                        </label>
                                    </div>
                                    <!-- setting_end_on_assigner_accept: end / setting_transferable: start -->
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="" name="setting_transferable" id="setting_transferable" checked="checked">
                                            <span>اجازه به مسئول، برای ارجاع به فرد دیگر</span>
                                        </label>
                                    </div>
                                    <!-- setting_end_on_assigner_accept: end -->
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="" name="setting_rejectable" id="setting_rejectable" checked="checked">
                                            <span>اجازه به مسئول، برای نپذیرفتن وظیفه</span>
                                        </label>
                                    </div>
                                    <!-- setting_end_on_assigner_accept: end -->
                                    <br/>
                                </div>
                                <!-- setting: end / schedule: start -->
                                <div class="tab-pane fade" id="schedule">
                                    <!-- [field_group]: start -->
                                    <div class="form-group">
                                        <!-- schedule_every: start -->
                                        <label class="col-sm-1 control-label" for="schedule_every">
                                            <span>در هر</span>
                                        </label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control schedule_every" id="schedule_every" name="schedule_every"/>
                                        </div>
                                        <!-- schedule_every: end / schedule_every_type: start -->
                                        <div class="col-sm-2">
                                            <select class="form-control schedule_every_type" id="schedule_every_type" name="schedule_every_type">
                                                <option value="minute">دقیقه</option>
                                                <option value="hour">ساعت</option>
                                                <option value="day">روز</option>
                                                <option value="weekly">هفته</option>
                                                <option value="monthly">ماه</option>
                                                <option value="seasonly">فصل</option>
                                                <option value="yearly">سال</option>
                                            </select>
                                        </div>
                                        <!-- schedule_every_type: end / [field_group]: start -->
                                        <div class="col-sm-8">
                                            <div style="border: /*lightgray*/ transparent solid 1px; padding: 0 20px 0 10px;">
                                                <!-- schedule_every_type_weekly: start -->
                                                <div class="row schedule_every_type_weekly" id="schedule_every_type_weekly">
                                                    @for ($i = 0; $i < 7; $i++)
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" class="" id="schedule_every_type_weekly_{!! $i !!}" name="schedule_every_type_weeklys[]" value="{!! $i !!}">
                                                                {!! $week_days[$i] !!}
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <!-- schedule_every_type_weekly: end / schedule_every_type_monthly: start -->
                                                <div class="row schedule_every_type_monthly" id="schedule_every_type_monthly">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" class="" id="schedule_every_type_monthly_{!! $i !!}" name="schedule_every_type_monthlys[]" value="{!! $i !!}">
                                                                {!! $month_weeks[$i] !!}
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <!-- schedule_every_type_monthly: end / schedule_every_type_seasonly: start -->
                                                <div class="row schedule_every_type_seasonly" id="schedule_every_type_seasonly">
                                                    @for ($i = 0; $i < 4; $i++)
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" class="" id="schedule_every_type_seasonly_{!! $i !!}" name="schedule_every_type_seasonlys[]" value="{!! $i !!}">
                                                                {!! $seasons[$i] !!}
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                                <!-- schedule_every_type_seasonly: end / schedule_every_type_yearly: start -->
                                                <div class="row schedule_every_type_yearly" id="schedule_every_type_yearly">
                                                    @for ($i = 0; $i < 12; $i++)
                                                        <div class="checkbox-inline">
                                                            <label>
                                                                <input type="checkbox" class="" id="schedule_every_type_yearly_{!! $i !!}" name="schedule_every_type_yearlys[]" value="{!! $i !!}">
                                                                {!! $year_months[$i] !!}
                                                            </label>
                                                        </div>
                                                        {{--@if (8 == $i) <br /> @endif--}}
                                                    @endfor
                                                </div>
                                                <!-- schedule_every_type_yearly: end -->
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <!-- [field_group]: end / [field_group]: start -->
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="">
                                            <span>شروع</span>
                                        </label>
                                        <!-- schedule_begin_by_date: start -->
                                        <div class="col-sm-1">
                                            <div class="radio-inline"><label for="schedule_begin_by_date"><input type="radio" class="schedule_begin_by_date" id="schedule_begin_by_date" name="schedule_begin_by" value="date"
                                                                                                                 checked="checked"/>در تاریخ</label></div>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control schedule_begin_by_date_value DatePicker_begin_date" id="schedule_begin_by_date_value" name="schedule_begin_by_date_value"/>
                                        </div>
                                        <!-- schedule_begin_by_date: end -->
                                    </div>
                                    <!-- [field_group]: end / [field_group]: start -->
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="" style="margin-top: 10px;">
                                            <span>پایان</span>
                                        </label>
                                        <!-- schedule_end_by_date: start -->
                                        <div class="col-sm-1" style="margin-top: 10px;">
                                            <div class="radio-inline"><label for="schedule_end_by_date"><input type="radio" class="schedule_end_by_date" id="schedule_end_by_date" name="schedule_end_by" value="date" checked="checked"/>در
                                                    تاریخ</label></div>
                                        </div>
                                        <div class="col-sm-2" style="margin-top: 10px;">
                                            <input type="text" class="form-control DatePicker_begin_date schedule_end_by_date_value" id="schedule_end_by_date_value" name="schedule_end_value"/>
                                        </div>
                                        <!-- schedule_end_by_date: end / schedule_end_by_recur: start -->
                                        <div class="col-sm-2">
                                            <div class="radio-inline">
                                                <label for="schedule_end_by_recur"><input type="radio" class="schedule_end_by_recur" id="schedule_end_by_recur" name="schedule_end_by" value="recur"/>بعد از</label>&nbsp;&nbsp;<input
                                                        type="text" class="form-control schedule_end_by_recur_value" id="schedule_end_by_recur_value" name="schedule_end_value" style="width: 50px; display: inline-block;" disabled="disabled"
                                                        value=""/>&nbsp;&nbsp;<label class="" for="schedule_end_by_recur_value">رویداد</label>
                                            </div>
                                        </div>
                                        <!-- schedule_end_by_date: end / schedule_end_never: start -->
                                        <div class="col-sm-1" style="margin-top: 10px;">
                                            <div class="radio-inline"><label for="schedule_end_never"><input type="radio" class="schedule_end_never" id="schedule_end_never" name="schedule_end_by" value="never"/>هرگز</label></div>
                                        </div>
                                        <!-- schedule_end_never: end -->
                                    </div>
                                    <hr/>
                                    <!-- [field_group]: end / schedule_creation: start -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="">
                                            <span>ایجاد وظایف</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <div class="radio-inline"><label for="schedule_creation_1"><input type="radio" class="schedule_creation" id="schedule_creation_1" name="schedule_creation" value="1" checked/>هم اکنون</label></div>
                                            <div class="radio-inline"><label for="schedule_creation_2"><input type="radio" class="schedule_creation" id="schedule_creation_2" name="schedule_creation" value="2"/>در زمان مقرر</label></div>
                                        </div>
                                    </div>
                                    <!-- schedule_creation: end -->
                                </div>
                                <!-- setting: end / resources: start -->
                                <div class="tab-pane fade" id="resources">
                                    <h3 style="text-align: center; margin-top: 100px;">این بخش در حال طراحی است.</h3>
                                </div>
                                <!-- resources: end / rels: start -->
                                <div class="tab-pane fade" id="rels">
                                    <h3 style="text-align: center; margin-top: 100px;">این بخش در حال طراحی است.</h3>
                                </div>
                                <!-- rels: end / resources: start -->
                                <div class="tab-pane fade" id="attachs">
                                    <multi_upload_image
                                            height="150px"
                                            title="بارگزاری فایل "
                                            :default_img_data_json='{!! $file !!}'
                                            :old_multifile_data='{{ $old_file }}'
                                    ></multi_upload_image>
                                </div>
                                <!-- attachs: end -->
                            </div>
                            <div class="clearfixed"></div>
                            <div class="row text-left">
                                <button type="submit" class="btn bg-teal-400 btn-labeled sumit_form_task_add"><b><i class="fa fa-save"></i></b>ذخیره</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section(config('laravel_task_manager.task_master_yield_footer_inline_javascript'))
    @include('laravel_task_manager::clients.tasks.create_task.helper.script')
@stop
