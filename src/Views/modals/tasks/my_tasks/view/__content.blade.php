@include('laravel_task_manager::modals.tasks.progress.template')
@php
    $types =
    [
        '<span style="color: green; font-weight: bold;">رویداد</span>&emsp;<span style="color: lightgray;">فعالیت</span>',
        '<span style="color: lightgray;">رویداد</span>&emsp;<span style="color: green; font-weight: bold;">فعالیت</span>',
    ];
    $importances =
    [
        '<span style="color: green; font-weight: bold;">غیر مهم</span>&emsp;<span style="color: lightgray;">مهم</span>',
        '<span style="color: lightgray;">غیر مهم</span>&emsp;<span style="color: red; font-weight: bold;">مهم</span>',
    ];
    $immediates =
    [
        '<span style="color: green; font-weight: bold;">غیر فوری</span>&emsp;<span style="color: lightgray;">فوری</span>',
        '<span style="color: lightgray;">غیر فوری</span>&emsp;<span style="color: red; font-weight: bold;">فوری</span>',
    ];
@endphp
<div id="form_message_box" class="form_message_area"></div>

    <div class="container col-md-12">
        <ul class="nav nav-tabs">
            <li class="tabs{!! 'details' == $default_tab ? ' active' : null !!}" data-tab-id="details"><a data-toggle="tab" href="#details">جزئیات</a></li>
            <li class="tabs{!! 'transcripts' == $default_tab ? ' active' : null !!}" data-tab-id="transcripts"><a data-toggle="tab" href="#transcripts">رونوشت&zwnj;ها</a></li>
            <li class="tabs{!! 'attachs' == $default_tab ? ' active' : null !!}" data-tab-id="attachs"><a data-toggle="tab" href="#attachs">پیوست&zwnj;ها</a></li>
            <li class="tabs{!! 'action' == $default_tab ? ' active' : null !!}" data-tab-id="action"><a data-toggle="tab" href="#action" style="color: #4caf50;">اقدام</a></li>
            <li class="tabs{!! 'response' == $default_tab ? ' active' : null !!}" data-tab-id="response"><a data-toggle="tab" href="#response" style="color: #4caf50;">پاسخ به کاربر</a></li>
            <li class="tabs{!! 'history' == $default_tab ? ' active' : null !!} pull-right" data-tab-id="history"><a data-toggle="tab" href="#history">تاریخچه</a></li>
        </ul>
        <div class="tab-content">
            <div id="details" class="tab-pane fade {!! 'details' == $default_tab ? 'in active' : null !!}">
                <table class="table table-striped">
                    {{--
                    <tr>
                        <td class="col-md-2" rowspan="2">ارجاع دهنده</td>
                        <td class="col-md-1" rowspan="2">{!! $task->assignment->assigner->avatar64 !!}</td>
                        <td class="col-md-3">{!! $task->assignment->assigner->full_name !!}</td>
                        <td class="col-md-2"></td>
                        <td class="col-md-4">{!! $importances[$task->employee_priority->importance] !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-3">{!! $task->assignment->assigner->username !!}</td>
                        <td class="col-md-1" style="border: 0;"></td>
                        <td class="col-md-4">{!! $immediates[$task->employee_priority->immediate] !!}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td class="col-md-2">شناسه</td>
                        <td class="col-md-2">{!! $task->code ? : 'درج نشده' !!}</td>
                        <td class="col-md-3"></td>
                        <td class="col-md-1" style="border: none;"></td>
                        <td class="col-md-2">{!! $types[$task->type] !!}</td>
                    </tr>
                    --}}
                    <tr style="font-weight: bold;">
                        <td class="col-md-2">شناسه</td>
                        <td class="col-md-10">{!! $task->code ? : 'درج نشده' !!}</td>
                    </tr>
                    @if($task->file_no)
                    <tr>
                        <td class="col-md-2">شماره پرونده</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">
                            {!! ltm_html_file_no_creator($task->file_no) !!}
                        </td>
                    </tr>
                    @endif
                    @if(isset($task->step_name) && $task->step_name)
                        <tr>

                            <td class="col-md-2">گام</td>
                            <td class="col-md-10" colspan="4" style="text-align: justify;">
                                {{$task->step_name}}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td class="col-md-2">موضوع</td>
                        <td class="col-md-10" colspan="4">{!! $task->subject->title !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">عنوان</td>
                        <td class="col-md-10" colspan="4">{!! $task->title !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">توضیحات</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">{!! $task->description ? $task->description : '<span style="color: lightgray;">بدون توضیحات</span>' !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">زمان شروع</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">{!! $task->jalali_start_time !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">مدت مهلت انجام</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">{!! $task->human_duration_timestamp !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">مهلت انجام باقیمانده</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">{!! $task->human_remaining_duration_timestamp !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-2">شماره پرونده</td>
                        <td class="col-md-10" colspan="4" style="text-align: justify;">
                            @if ($task->file_no)
                                @if (1 == $task->file_data['status'])
                                    @foreach ($task->file_data['data'] as $row)
                                        <div class="row panel" >{!! $row !!}</div>
                                    @endforeach
                                @else
                                    <span class="text-danger">{!! $task->file_data['data'] !!}</span>
                                @endif
                            @else
                                <span style="color: lightgray;">بدون شماره پرونده</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-2">کلیدواژه&zwnj;ها</td>
                        <td class="col-md-10" colspan="4" style="margin-left: 0; padding-left: 0;">
                            @forelse ($task->keywords as $keyword)
                                <nobr class="keyword"><i class="fa fa-tag"></i><span>{!! $keyword->title !!}</span></nobr>
                            @empty
                                <span style="color: lightgray;">بدون کلیدواژه</span>
                            @endforelse
                        </td>
                    </tr>
                </table>
            </div>
            <div id="transcripts" class="tab-pane fade {!! 'transcripts' == $default_tab ? 'in active' : null !!}">
                <table class="table table_transcripts" id="table_transcripts"></table>
            </div>
            <div id="attachs" class="tab-pane fade {!! 'attachs' == $default_tab ? 'in active' : null !!}">
                {!! $LFM_show !!}
            </div>
            <div id="action" class="tab-pane fade {!! 'action' == $default_tab ? 'in active' : null !!}">
                <form class="form-horizontal form_action" id="form_action" name="form_action">
                    <input type="hidden" class="task_id" id="task_id" name="task_id" value="{!! ltm_encode_ids([$task->id]) !!}" />
                    <input type="hidden" class="task_assignment_id" id="task_assignment_id" name="task_assignment_id" value="{!! ltm_encode_ids([$task->assignment->id]) !!}" />
                    <input type="hidden" class="action_do_status_old" id="action_do_status_old" name="action_do_status_old" value="{!! $task->assignment->current_status->status !!}" />
                    <input type="hidden" class="action_do_status_percent_old" id="action_do_status_percent_old" name="action_do_status_percent_old" value="{!! $task->assignment->current_status->percent !!}" />
                    <input type="hidden" class="action_do_importance_old" id="action_do_importance_old" name="action_do_importance_old" value="{!! $task->employee_priority->importance !!}" />
                    <input type="hidden" class="action_do_immediate_old" id="action_do_immediate_old" name="action_do_immediate_old" value="{!! $task->employee_priority->immediate !!}" />
                <!-- action_type: start -->
                @if (2 == $task->assignment->current_status->status)
                    <div class="well">این وظیفه را انجام داده اید.</div>
                @else
                    <div class="well">ابتدا نوع اقدام را انتخاب نمائید:</div>
                    <div class="form-group margin-top-20">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a @if (true)data-toggle="tab" onclick="tab_action_type_click('#action_type_1', 1);" @endif href="#tab_action_do"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_1" name="action_type" value="1" checked="checked" />انجام</div></a></li>
                                <li><a @if ($task->assignment->transferable)data-toggle="tab" onclick="tab_action_type_click('#action_type_2', 2);" @endif href="#tab_action_transfer"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_2" name="action_type" value="2" @if (!$task->assignment->transferable)disabled="disabled" @endif/>ارجاع</div></a></li>
                                <li><a @if ($task->assignment->rejectable)data-toggle="tab" onclick="tab_action_type_click('#action_type_3', 3);" @endif href="#tab_action_reject"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_3" name="action_type" value="3" @if (!$task->assignment->rejectable)disabled="disabled" @endif/>نپذیرفتن</div></a></li>
                                {{--
                                <li class="active"><a data-toggle="tab" onclick="tab_action_type_click('#action_type_1');" href="#tab_action_do"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_1" name="action_type" value="1" checked="checked" />انجام</div></a></li>
                                <li><a data-toggle="tab" onclick="tab_action_type_click('#action_type_2');" href="#tab_action_transfer"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_2" name="action_type" value="2" @if (!$task->transferable)disabled="disabled" @endif/>ارجاع</div></a></li>
                                <li><a data-toggle="tab" onclick="tab_action_type_click('#action_type_3');" href="#tab_action_reject"><div class="radio-inline"><input style="pointer-events: none;" type="radio" class="action_type pointer" id="action_type_3" name="action_type" value="3" @if (!$task->rejectable)disabled="disabled" @endif/>نپذیرفتن</div></a></li>
                                --}}
                            </ul>
                            <div class="tab-content">
                                <!-- do: start -->
                                <div id="tab_action_do" class="tab-pane fade in active">
                                    <table class="table table-striped">
                                        <!-- action_do_status: start -->
                                        <tr>
                                            <td class="col-md-2">
                                                <span>وضعیت</span>
                                                <span class="red_star">*</span>
                                            </td>
                                            <td class="col-md-10">
                                                @if (2 == $task->assignment->current_status->status)
                                                    انجام شده
                                                    <input type="hidden" class="action_do_status" name="action_do_status" value="-1" />
                                                @else
                                                    <div class="form-group fg_action_do">
                                                        <div class="radio-inline" style="margin-top: 10px;"><label for="action_do_status_0"><input type="radio" class="action_do_status" id="action_do_status_0" name="action_do_status" value="0" @if (0 == $task->assignment->current_status->status)checked="checked" @endif/>{!! config('tasks.statuses.0') !!}</label></div>
                                                        <div class="radio-inline"><label for="action_do_status_1"><input type="radio" class="action_do_status" id="action_do_status_1" name="action_do_status" value="1" @if (1 == $task->assignment->current_status->status)checked="checked" @endif/>{!! config('tasks.statuses.1') !!}</label>&nbsp;&nbsp;<input type="text" class="form-control action_do_status_percent" id="action_do_status_percent" name="action_do_status_percent" style="width: 50px; display: inline-block;" @if (1 != $task->assignment->current_status->status)disabled="disabled" @endif value="{!! $task->assignment->current_status->percent !!}" />&nbsp;&nbsp;<label class="" for="action_do_status_percent">درصد پیشرفت</label></div>
                                                        <div class="radio-inline" style="margin-top: 10px;"><label for="action_do_status_2"><input type="radio" class="action_do_status" id="action_do_status_2" name="action_do_status" value="2" @if (2 == $task->assignment->current_status->status)checked="checked" @endif/>{!! config('tasks.statuses.2') !!}</label></div>
                                                        <div class="messages message_a0"></div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- action_do_status: end / action_do_importance: start -->
                                        <tr>
                                            <td class="col-md-2">اهمیت از نظر شما</td>
                                            <td class="col-md-10">
                                                <div class="radio-inline"><label for="action_do_importance_0"><input type="radio" id="action_do_importance_0" name="action_do_importance" value="0" value="3" @if (0 == $task->employee_priority->importance)checked="checked" @endif/>غیر مهم</label></div>
                                                <div class="radio-inline"><label for="action_do_importance_1"><input type="radio" id="action_do_importance_1" name="action_do_importance" value="1" value="3" @if (1 == $task->employee_priority->importance)checked="checked" @endif/>مهم</label></div>
                                            </td>
                                        </tr>
                                        <!-- action_do_importance: end / action_do_immediate: start -->
                                        <tr>
                                            <td class="col-md-2">فوریت از نظر شما</td>
                                            <td class="col-md-10">
                                                <div class="radio-inline"><label for="action_do_immediate_0"><input type="radio" id="action_do_immediate_0" name="action_do_immediate" value="0" @if (0 == $task->employee_priority->immediate)checked="checked" @endif/>غیر فوری</label></div>
                                                <div class="radio-inline"><label for="action_do_immediate_1"><input type="radio" id="action_do_immediate_1" name="action_do_immediate" value="1" @if (1 == $task->employee_priority->immediate)checked="checked" @endif/>فوری</label></div>
                                            </td>
                                        </tr>
                                        <!-- action_do_immediate: end -->
                                        @foreach ($action_do_form_fields as $action_do_form_field_k => $action_do_form_field)
                                            <tr class="custom_action_do_form" style="display: none;">
                                                <td class="col-md-2">{!! $action_do_form_field_k !!}</td>
                                                <td class="col-md-10">{!! $action_do_form_field !!}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <!-- do: end / transfer: start -->
                                <div id="tab_action_transfer" class="tab-pane fade">
                                    @if ($task->assignment->transferable)
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#tab_action_transfer_general">تعریف</a></li>
                                            <li><a data-toggle="tab" href="#tab_action_transfer_setting">تنظیمات</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab_action_transfer_general">
                                                <table class="table table-striped">
                                                    <!-- action_transfer_importance: start -->
                                                    <tr>
                                                        <td class="col-md-2">اهمیت از نظر شما</td>
                                                        <td class="col-md-10">
                                                            <div class="radio-inline"><label for="action_transfer_importance_0"><input type="radio" id="action_transfer_importance_0" name="action_transfer_importance" value="0" value="3" @if (0 == $task->employee_priority->importance)checked="checked" @endif/>غیر مهم</label></div>
                                                            <div class="radio-inline"><label for="action_transfer_importance_1"><input type="radio" id="action_transfer_importance_1" name="action_transfer_importance" value="1" value="3" @if (1 == $task->employee_priority->importance)checked="checked" @endif/>مهم</label></div>
                                                        </td>
                                                    </tr>
                                                    <!-- action_transfer_importance: end / action_transfer_immediate: start -->
                                                    <tr>
                                                        <td class="col-md-2">فوریت از نظر شما</td>
                                                        <td class="col-md-10">
                                                            <div class="radio-inline"><label for="action_transfer_immediate_0"><input type="radio" id="action_transfer_immediate_0" name="action_transfer_immediate" value="0" @if (0 == $task->employee_priority->immediate)checked="checked" @endif/>غیر فوری</label></div>
                                                            <div class="radio-inline"><label for="action_transfer_immediate_1"><input type="radio" id="action_transfer_immediate_1" name="action_transfer_immediate" value="1" @if (1 == $task->employee_priority->immediate)checked="checked" @endif/>فوری</label></div>
                                                        </td>
                                                    </tr>
                                                    <!-- action_transfer_immediate: end / action_transfer_user: start -->
                                                    <tr>
                                                        <td class="col-md-2 form-group fg_action_transfer_user">
                                                            <label class="control-label" for="action_transfer_user">
                                                                <span>مسئول</span>
                                                                <span class="red_star">*</span>
                                                            </label>
                                                        </td>
                                                        <td class="col-md-10 form-group fg_action_transfer_user">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                        <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                                                            <i class="fa fa-child jsPanel-s" data-href="" style="cursor: pointer; font-size: 18px;"></i>
                                                                        </span>
                                                                    <span style="padding-right: 5px;">0</span>
                                                                </div>
                                                                <select class="action_transfer_user" id="action_transfer_user" name="action_transfer_user"></select>
                                                            </div>
                                                            <div class="messages"></div>
                                                        </td>
                                                    </tr>
                                                    <!-- action_transfer_user: end / action_transfer_transcripts_cc: start -->
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <label class="control-label" for="action_transfer_transcripts_cc">رونوشت عمومی</label>
                                                        </td>
                                                        <td class="col-md-10">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                            <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                                                <i class="fa fa-child jsPanels" data-href="http://a.com" style="cursor: pointer; font-size: 18px;"></i>
                                                            </span>
                                                                    <span style="padding-right: 5px;">0</span>
                                                                </div>
                                                                <select class="form-control action_transfer_transcripts_cc" id="action_transfer_transcripts_cc" name="action_transfer_transcripts_cc[]" multiple></select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- action_transfer_transcripts_cc: end / action_transfer_transcripts_bcc: start -->
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <label class="control-label" for="action_transfer_transcripts_bcc">رونوشت خصوصی</label>
                                                        </td>
                                                        <td class="col-md-10">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <span style="border-left: gray dotted 1px; padding-left: 10px;">
                                                                        <i class="fa fa-child jsPanels" data-href="http://a.com" style="cursor: pointer; font-size: 18px;"></i>
                                                                    </span>
                                                                    <span style="padding-right: 5px;">0</span>
                                                                </div>
                                                                <select class="form-control action_transfer_transcripts_bcc" id="action_transfer_transcripts_bcc" name="action_transfer_transcripts_bcc[]" multiple></select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- transfer_: end -->
                                                    @foreach ($action_transfer_form_fields as $action_transfer_form_field_k => $action_transfer_form_field)
                                                        <tr>
                                                            <td class="col-md-2">{!! $action_transfer_form_field_k !!}</td>
                                                            <td class="col-md-10">{!! $action_transfer_form_field !!}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="tab_action_transfer_setting">
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
                                                                <select type="text" class="form-control action_transfer_do_form_id" id="action_transfer_do_form_id" name="action_transfer_do_form_id"></select>
                                                                <div class="messages"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group fg_setting_action_transfer_form_id">
                                                            <label class="col-sm-2 control-label" for="setting_action_transfer_form_id">
                                                                <span>فرم ارجاع</span>
                                                                <span class="red_star"></span>
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <select type="text" class="form-control action_transfer_transfer_form_id" id="action_transfer_transfer_form_id" name="action_transfer_transfer_form_id"></select>
                                                                <div class="messages"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group fg_setting_action_reject_form_id">
                                                            <label class="col-sm-2 control-label" for="setting_action_reject_form_id">
                                                                <span>فرم نپذیرفتن</span>
                                                                <span class="red_star"></span>
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <select type="text" class="form-control action_transfer_reject_form_id" id="action_transfer_reject_form_id" name="action_transfer_reject_form_id"></select>
                                                                <div class="messages"></div>
                                                            </div>
                                                        </div>
                                                        <!-- setting_messaging: end -->
                                                    </fieldset>
                                                </div>
                                                <br />
                                                <!-- action: end / messaging: start -->
                                                <div class="well">
                                                    <fieldset>
                                                        <legend>تنظیمات اطلاع رسانی</legend>
                                                        <!-- action_transfer_email: start -->
                                                        <div class="form-group">
                                                            <div class="checkbox-inline col-sm-2">
                                                                <label>
                                                                    <input type="checkbox" class="action_transfer_email" id="action_transfer_email" name="action_transfer_email[]" value="is_active">
                                                                    <span>ایمیل</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-10 fg_action_transfer_email">
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_email_users" name="action_transfer_email[]" value="users">
                                                                        <span>مسئول</span>
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_email_transcripts" name="action_transfer_email[]" value="transcripts">
                                                                        <span>رونوشت گیرندگان</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- action_transfer_email: end / action_transfer_sms: start -->
                                                        <div class="form-group">
                                                            <div class="checkbox-inline col-sm-2">
                                                                <label>
                                                                    <input type="checkbox" class="action_transfer_sms" id="action_transfer_sms" name="action_transfer_sms[]" value="is_active">
                                                                    <span>پیامک</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-10 fg_action_transfer_sms">
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_sms_users" name="action_transfer_sms[]" value="users">
                                                                        <span>مسئول</span>
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_sms_transcripts" name="action_transfer_sms[]" value="transcripts">
                                                                        <span>رونوشت گیرندگان</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- action_transfer_sms: end / action_transfer_messaging: start -->
                                                        <div class="form-group">
                                                            <div class="checkbox-inline col-sm-2">
                                                                <label>
                                                                    <input type="checkbox" class="action_transfer_messaging" id="action_transfer_messaging" name="action_transfer_messaging[]" value="is_active">
                                                                    <span>پیام رسان</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-10 fg_action_transfer_messaging">
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_messaging_users" name="action_transfer_messaging[]" value="users">
                                                                        <span>مسئول</span>
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox-inline">
                                                                    <label>
                                                                        <input type="checkbox" class="" id="action_transfer_messaging_transcripts" name="action_transfer_messaging[]" value="transcripts">
                                                                        <span>رونوشت گیرندگان</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- action_transfer_messaging: end -->
                                                    </fieldset>
                                                </div>
                                                <br />
                                                <!-- messaging: end / action_transfer_end_on_assigner_accept: start -->
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="" name="action_transfer_end_on_assigner_accept" id="action_transfer_end_on_assigner_accept" checked="checked">
                                                        <span>پایان یافتن با اعلان ارجاع دهنده</span>
                                                    </label>
                                                </div>
                                                <!-- action_transfer_transferable: end / action_transfer_transferable: start -->
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="" name="action_transfer_transferable" id="action_transfer_transferable" checked="checked">
                                                        <span>امکان ارجاع به فرد دیگر</span>
                                                    </label>
                                                </div>
                                                <!-- action_transfer_end_on_assigner_accept: end -->
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="" name="action_transfer_rejectable" id="action_transfer_rejectable" checked="checked">
                                                        <span>اجازه به مسئول، برای نپذیرفتن وظیفه</span>
                                                    </label>
                                                </div>
                                                <!-- action_transfer_end_on_assigner_accept: end -->
                                                <br />
                                            </div>
                                        </div>
                                    @else
                                        امکان ارجاع وجود ندارد.
                                    @endif
                                </div>
                                <!-- transfer: end / reject: start -->
                                <div id="tab_action_reject" class="tab-pane fade">
                                    @if ($task->assignment->rejectable)
                                        <table class="table table-striped">
                                            <tr>
                                                <td colspan="2" class="col-md-12 form-group fg_action_reject_accept">
                                                    <div class="checkbox-inline">
                                                        <label>
                                                            <input type="checkbox" class="action_reject_accept" id="action_reject_accept" name="action_reject_accept" value="">
                                                            <span>مطمئن هستم که امکان انجام این وظیفه را ندارم.</span>
                                                        </label>
                                                    </div>
                                                    <div class="messages"></div>
                                                </td>
                                            </tr>
                                            @foreach ($action_reject_form_fields as $action_reject_form_field_k => $action_reject_form_field)
                                                <tr>
                                                    <td class="col-md-2">{!! $action_reject_form_field_k !!}</td>
                                                    <td class="col-md-10">{!! $action_reject_form_field !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        امکان نپذیرفتن وجود ندارد.
                                    @endif
                                </div>
                                <!-- reject: end -->
                            </div>
                        </div>
                    </div>
                @endif
                    <button type="submit" class="submit_form_action hidden">submit</button>
                </form>
            </div>
            <div id="response"  class="tab-pane">
                @if (count($chats) > 0)
                    @include('laravel_task_manager::clients.tasks.panels.jspanel.helpers.track_style')
                    <div class="">
                        <ul class="ltm-timeline">
                            @foreach ($chats as $chat)
                                @php($timeline_class='')
                                @if($chat->is_message_from_client == '0')
                                    @php($timeline_class = 'ltm-timeline-inverted')
                                @endif
                                <li class="{{$timeline_class}}">
                                    <div class="ltm-timeline-badge">{!! $chat->avatar_image !!}</div>
                                    <div class="ltm-timeline-panel">
                                        <div class="ltm-timeline-heading">
                                            <div class="col-md-6">
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-user"></i> {{$chat->user->full_name}}</small></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {!! ltm_Date_GtoJ($chat->created_at, 'Y/m/d - H:i') !!}</small></p>
                                            </div>
                                        </div>
                                        <hr  style="margin-bottom: 10px;    clear: both;">
                                        <div class="ltm-timeline-title col-md-12" style="margin-bottom: 15px;">
                                            <p>{{$chat->description}}</p>
                                        </div>
                                        <hr  style="margin-bottom: 10px;    clear: both;">

                                        <div class="ltm-timeline-body">
                                            <div class="col-md-6">
                                                <p style="font-size: 11px">فایل های پیوست :</p></div>
                                            <div class="col-md-6">
                                                @if($chat->file_id)
                                                    <a style="float: left;font-size: 21px;" href="{{ LFM_GenerateDownloadLink('ID', $chat->file_id, 'original', '404_user_avatar.jpg')}}"><i class="fa fa-file-zip-o img-file-thumbnail"></i></a>
                                                @else
                                                    ----
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="well">موردی برای نمایش وجود ندارد.</div>
                @endif
                <div class="space-10"></div>
                @if($is_final_assigment)
                        <div id="form_message_box_track" class="form_message_area"></div>
                        <form class="form-horizontal form_task_add" id="form_track_task" name="form_task_add">
                            <input type="hidden" name="assignment_id" value="{{$assignment_id}}">
                            <input type="hidden" name="type" value="response">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="track_description">
                                    <span>توضیحات</span>
                                </label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" id="track_description" name="description_track" rows="5"></textarea>
                                    <div class="messages"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12">
                                <label class="col-sm-2 control-label">
                                    پیوست فایل
                                </label>
                                <div class="col-sm-10">
                                    <script>
                                        function callback_track(result)
                                        {
                                            $('#result_track').html(result.attachment_track.view.small) ;
                                        }
                                    </script>
                                    {!! $lfm_track['button'] !!}
                                    {!! $lfm_track['modal_content'] !!}
                                    <div  id="result_track"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit" id="submit_insert_track" class="hidden"></button>
                        </form>
                @endif
            </div>
            <div id="history" class="tab-pane fade {!! 'history' == $default_tab ? 'in active' : null !!}">
                <!-- Timeline -->
                @if ($task->logs->count())
                <div class="timeline timeline-left">
                    <div class="timeline-container">
                        <div class="timeline-date text-muted">
                            {{--<i class="icon-history position-left"></i> <span class="text-semibold">Monday</span>, April 18--}}
                        </div>
                        @foreach ($task->logs as $log)
                            <div class="timeline-row">
                                <div class="timeline-icon">
                                    <img src="{!! url('vendor/laravel_task_manager/images/placeholder.jpg') !!}" alt="">
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-flat timeline-content">
                                            <div class="panel-heading">
                                                <h6 class="panel-title"><i class="icon-checkmark-circle position-left text-success"></i>{!! ltm_task_log_fetch($log->type, $log->title_values, 'title') !!}</h6>
                                                <div class="heading-elements">
                                                    <span class="heading-text"><i class="icon-history position-left"></i>{!! ltm_Date_GtoJ($log->created_at, 'Y/m/d - H:i') !!}</span>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <a href="#" class="display-block content-group">
                                                    <img src="/vendor/laravel_task_manager/images/cover.jpg" class="img-responsive content-group" alt="">
                                                </a>
                                                <h6 class="content-group">
                                                    {!! ltm_task_log_fetch($log->type, $log->description_values, 'description') !!}
                                                </h6>
                                                @include('laravel_task_manager::modals.tasks.task.log.form')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <div class="well">موردی برای نمایش وجود ندارد.</div>
                @endif
                <!-- /timeline -->
            </div>
        </div>
    </div>





