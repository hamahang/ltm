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
    <!-- [field_group]: start -->
    <div class="form-group row" style="margin-bottom: 0;">
        <label class="col-md-3">
            <label>اهمیت :</label>
            <span class="red_star">*</span>
        </label>
        <div class="col-md-6">
            <label class="radio-inline" style="min-width: 110px">
                <input type="radio" id="general_importance_0" name="general_importance" value="0" checked />
                <span>غیر مهم</span>
            </label>
            <label class="radio-inline" style="min-width: 110px">
                <input type="radio" id="general_importance_1" name="general_importance" value="1" />
                <span>مهم</span>
            </label>
        </div>
       <div class="messages col-md-3"></div>
    </div>
    <div class="form-group row">
        <label class="col-md-3">
            <label>فوریت :</label>
            <span class="red_star">*</span>
        </label>
        <div class="col-md-6">
            <label class="radio-inline" style="min-width: 110px">
                <input type="radio" id="general_immediate_0" name="general_immediate" value="0" checked />
                <span>غیر فوری</span>
            </label>
            <label class="radio-inline" style="min-width: 110px">
                <input type="radio" id="general_immediate_1" name="general_immediate" value="1" />                <span>فوری</span>
            </label>
        </div>
        <div class="messages col-md-3"></div>
    </div>
    @if($user_requestes)
        <div class="form-group row fg_general_file_no">
            <label class="col-md-3 control-label" for="general_file_no">
                <span>شماره پرونده</span>
                <span class="red_star">*</span>
            </label>
            <div class="col-md-6">
                <select type="text" class="form-control general_file_no" id="general_file_no" name="file_no" @if($request_id) disabled @endif>
                    @if($request_id)
                        <option value="{{$request_id}}">{{$request_id}}</option>
                    @else
                        <option></option>
                    @endif
                </select>
            </div>
            <div class="messages col-md-3"></div>
        </div>
    @endif
    @if(is_array($step) || !$step)
        <div class="form-group row fg_general_step_id">
            <label class="col-md-3 control-label" for="general_step_id">
                <span>عنوان گام</span>
                <span class="red_star">*</span>
            </label>
            <div class="col-md-6">
                <select type="text" class="form-control general_step_id" id="general_step_id" name="step_id" @if($step && isset($request_id) && $request_id) disabled @endif>
                    @if($step && isset($request_id) && $request_id)
                        <option value="{{$step['id']}}">{{$step['title']}}</option>
                    @else
                        <option></option>
                    @endif
                </select>
            </div>
            <div class="messages col-md-3"></div>
        </div>
@endif
<!-- [field_group]: end / general_title: start -->
    <div class="form-group row fg_general_title">
        <label class="col-md-3 control-label" for="general_title">
            <span>عنوان</span>
            <span class="red_star">*</span>
        </label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="general_title" name="general_title" />
        </div>
        <div class="messages col-md-3"></div>
    </div>
    <!-- general_title: end / general_subject_id: start -->
    <div class="form-group row">
        <label class="col-md-3 control-label" for="general_subject_id">
            <span>موضوع</span>
            <span class="red_star">*</span>
        </label>
        <div class="col-md-6">
            <select type="text" class="form-control general_subject_id" id="general_subject_id" name="general_subject_id">
                <option value=""></option>
            </select>
        </div>
        <div class="messages col-md-3"></div>
    </div>
    <!-- general_subject_id: end / general_description: start -->
    <div class="form-group row">
        <label class="col-md-3 control-label" for="general_description">
            <span>توضیحات</span>
        </label>
        <div class="col-md-6">
            <textarea type="text" class="form-control" id="general_description" name="general_description" rows="5"></textarea>
        </div>
        <div class="messages col-md-3"></div>
    </div>
    <hr />
    <!-- general_transcripts_bcc: end / general_keywords: start -->
    <div class="form-group row fg_general_keywords">
        <label class="col-md-3 control-label" for="general_keywords">
            <span>کلیدواژه&zwnj;ها</span>
        </label>
        <div class="col-md-6">
            <select class="form-control general_keywords" id="general_keywords" name="general_keywords[]" multiple></select>
        </div>
        <div class="messages col-md-3"></div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group row">
        <label class="col-md-3 control-label">
            پیوست فایل
        </label>
        <div class="col-md-6" id="upload_image_{{$variable}}">
            <upload_image
                    ref="uploadImage"
                    height="150px"
                    title="بارگزاری تصویر"
                    :default_img_data_json = '{!! $file !!}'
                    :old_default_img_data_json='{{ $old_file }}'
            ></upload_image>
        </div>
        <div class="messages col-md-3"></div>
    </div>
    <button type="submit" id="submit_insert_task_{{$variable}}" class="submit_form_task_add hidden"></button>
</form>

