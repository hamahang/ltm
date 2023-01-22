@php
    $week_days = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', ];
    $month_weeks = ['اولین', 'دومین', 'سومین', 'چهارمین', 'آخرین', ];
    $seasons = ['بهار', 'تابستان', 'پاییز', 'زمستان', ];
    $year_months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند ', ];
@endphp
<div id="form_message_box_{{$variable}}" class="form_message_area"></div>
<form class="form-horizontal form_task_add" id="form_task_add_{{$variable}}" name="form_task_add">
    <input type="hidden" name="request_id" value="{{$request_id}}">
    <input type="hidden" name="general_step_id" value="{{@$step['id']}}">
    <!-- tabs: start -->
    <div class="tab-pane fade in active" id="general">
        <!-- [field_group]: start -->
        <div class="form-group" style="margin-bottom: 0;">
            <div class="col-md-2"></div>
            <div class="col-md-5 form-group fg_general_importance">
                <div class="radio-inline">
                    <label>اهمیت :</label>
                    <span class="red_star">*</span>
                </div>
                <div class="radio-inline"><label for="general_importance_0"><input type="radio" id="general_importance_0" name="general_importance" value="0" checked />غیر مهم</label></div>
                <div class="radio-inline"><label for="general_importance_1"><input type="radio" id="general_importance_1" name="general_importance" value="1" />مهم</label></div>
                <div class="messages"></div>
            </div>
            <div class="col-md-5 form-group fg_general_immediate">
                <div class="radio-inline">
                    <label>فوریت :</label>
                    <span class="red_star">*</span>
                </div>
                <div class="radio-inline"><label for="general_immediate_0"><input type="radio" id="general_immediate_0" name="general_immediate" value="0" checked />غیر فوری</label></div>
                <div class="radio-inline"><label for="general_immediate_1"><input type="radio" id="general_immediate_1" name="general_immediate" value="1" />فوری</label></div>
                <div class="messages"></div>
            </div>
            <!-- general_immediate: end -->
        </div>
        @if($user_requestes)
            <div class="form-group fg_general_file_no">
                <label class="col-sm-2 control-label" for="general_file_no">
                    <span>شماره پرونده</span>
                    <span class="red_star">*</span>
                </label>
                <div class="col-sm-10">
                    <select type="text" class="form-control general_file_no" id="general_file_no" name="file_no" @if($request_id) disabled @endif>
                        @if($request_id)
                            <option value="{{$request_id}}">{{$request_id}}</option>
                        @else
                            <option></option>
                        @endif
                    </select>
                    <div class="messages"></div>
                </div>
            </div>
        @endif
        @if(is_array($step) || !$step)
            <div class="form-group fg_general_step_id">
                <label class="col-sm-2 control-label" for="general_step_id">
                    <span>عنوان گام</span>
                    <span class="red_star">*</span>
                </label>
                <div class="col-sm-10">
                    <select type="text" class="form-control general_step_id" id="general_step_id" name="step_id" @if($step && isset($request_id) && $request_id) disabled @endif>
                        @if($step && isset($request_id) && $request_id)
                            <option value="{{$step['id']}}">{{$step['title']}}</option>
                        @else
                            <option></option>
                        @endif
                    </select>
                    <div class="messages"></div>
                </div>
            </div>
        @endif
        <!-- [field_group]: end / general_title: start -->
        <div class="form-group fg_general_title">
            <label class="col-sm-2 control-label" for="general_title">
                <span>عنوان</span>
                <span class="red_star">*</span>
            </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="general_title" name="general_title" />
                <div class="messages"></div>
            </div>
        </div>
        <!-- general_title: end / general_subject_id: start -->
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <label class="col-sm-10 control-label text-right" >
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
        <hr />
        <!-- general_transcripts_bcc: end / general_keywords: start -->
        <div class="form-group fg_general_keywords">
            <label class="col-sm-2 control-label" for="general_keywords">
                <span>کلیدواژه&zwnj;ها</span>
            </label>
            <div class="col-sm-10">
                <select class="form-control general_keywords" id="general_keywords" name="general_keywords[]" multiple></select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12">
            <label class="col-sm-2 control-label">
                پیوست فایل
            </label>
            <div class="col-sm-10">
                <script>
                    function callback(result)
                    {
                        $('#result').html(result.attachment.view.small) ;
                    }
                </script>
                {!! $LFM['button'] !!}
                {!! $LFM['modal_content'] !!}
                <div id="result"></div>
            </div>
        </div>
    </div>
    <button type="submit" id="submit_insert_task_{{$variable}}" class="submit_form_task_add hidden"></button>
</form>
@include('laravel_task_manager::clients.tasks.panels.jspanel.helpers.jspanel_add_script')

