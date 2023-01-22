<form class="form-horizontal form_task_integrate" id="form_task_integrate" name="form_task_integrate">
    <!-- hidden fields -->
    <input type="hidden" class="hashed_ids" id="hashed_ids" name="hashed_ids" value="{!! $hashed_ids !!}" />
    <!-- tabs: start -->
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#selection">موارد انتخابی</a></li>
        <li class="active"><a data-toggle="tab" href="#general">تعریف</a></li>
        <li><a data-toggle="tab" href="#setting">تنظیمات</a></li>
        <li><a data-toggle="tab" href="#resources">منابع</a></li>
        <li><a data-toggle="tab" href="#rels">روابط</a></li>
        <li><a data-toggle="tab" href="#attachs">پیوست&zwnj;ها</a></li>
    </ul>
    <!-- tabs: end / content: start -->
    <div class="tab-content">
        <!-- selection: start -->
        <div class="tab-pane fade" id="selection">
            <table class="table table_choices" id="table_choices"></table>
        </div>
        <!-- selection: end / general: start -->
        <div class="tab-pane fade in active" id="general">
            <!-- [field_group]: start -->
            <div class="form-group" style="margin-bottom: 0;">
                <label class="col-sm-2 control-label" for="fg_general_type">
                    <span>نوع</span>
                    <span class="red_star">*</span>
                </label>
                <!-- general_type: start -->
                <div class="col-md-4 form-group fg_general_type">
                    <div class="radio-inline"><label for="general_type_0"><input type="radio" id="general_type_0" name="general_type" value="0" checked />رویداد</label></div>
                    <div class="radio-inline"><label for="general_type_1"><input type="radio" id="general_type_1" name="general_type" value="1" />فعالیت</label></div>
                    <div class="messages"></div>
                </div>
                <!-- general_type: end / general_importance: start -->
                <div class="col-md-3 form-group fg_general_importance">
                    <div class="radio-inline"><label for="general_importance_0"><input type="radio" id="general_importance_0" name="general_importance" value="0" checked />غیر مهم</label></div>
                    <div class="radio-inline"><label for="general_importance_1"><input type="radio" id="general_importance_1" name="general_importance" value="1" />مهم</label></div>
                    <div class="messages"></div>
                </div>
                <!-- general_importance: end / general_immediate: start -->
                <div class="col-md-3 form-group fg_general_immediate">
                    <div class="radio-inline"><label for="general_immediate_0"><input type="radio" id="general_immediate_0" name="general_immediate" value="0" checked />غیر فوری</label></div>
                    <div class="radio-inline"><label for="general_immediate_1"><input type="radio" id="general_immediate_1" name="general_immediate" value="1" />فوری</label></div>
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
                    <input type="text" class="form-control" id="general_title" name="general_title" />
                    <div class="messages"></div>
                </div>
            </div>
            <!-- general_title: end / general_subject_id: start -->
            <div class="form-group">
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
            <!-- general_description: end / general_user : start -->
            <div class="form-group fg_general_user">
                <label class="col-sm-2 control-label" for="general_user">
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
                        <select class="general_user"  id="general_user"  name="general_user"    multiple="multiple"></select>
                    </div>
                    <div class="messages"></div>
                </div>
            </div>
            <!-- general_user : end / general_transcripts_cc: start -->
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
                        <select class="form-control general_transcripts_cc" id="general_transcripts_cc" name="general_transcripts_cc[]" multiple></select>
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
                        <select class="form-control general_transcripts_bcc" id="general_transcripts_bcc" name="general_transcripts_bcc[]" multiple></select>
                    </div>
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
            <!-- general_keywords: end / general_file_no: start -->
            <div class="form-group">
                <label class="col-sm-2 control-label" for="general_file_no">
                    <span>شماره پرونده</span>
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="general_file_no" name="general_file_no" value="0" />
                </div>
            </div>
            <!-- general_file_no: end / general_deadline: start -->
            <div class="form-group general_deadline">
                <label class="col-sm-2 control-label" for="general_deadline">
                    <span>مهلت انجام</span>
                    <span class="red_star">*</span>
                </label>
                <div class="col-md-10">
                    <div class="radio-inline"><label for="general_deadline_1"><input type="radio" class="general_deadline" id="general_deadline_1" name="general_deadline" value="1" checked />آنی</label></div>
                    <div class="radio-inline"><label for="general_deadline_2"><input type="radio" class="general_deadline" id="general_deadline_2" name="general_deadline" value="2" />در زمان مقرر</label></div>
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
                        <input type="text" class="form-control general_deadline_from_date" id="general_deadline_from_date" name="general_deadline_from_date" />
                    </div>
                    <label class="col-sm-1 col-sm-offset-1 control-label" for="general_deadline_from_time">ساعت</label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control general_deadline_from_time" id="general_deadline_from_time" name="general_deadline_from_time" />
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
                        <input type="text" class="form-control general_deadline_to_date" id="general_deadline_to_date" name="general_deadline_to_date" />
                    </div>
                    <label class="col-sm-1 col-sm-offset-1 control-label" for="general_deadline_to_time">
                        <span>ساعت</span>
                    </label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control general_deadline_to_time" id="general_deadline_to_time" name="general_deadline_to_time" />
                    </div>
                </div>
                <div class="fg_general_deadline_to_duration">
                    <div class="col-sm-1 col-sm-offset-1">
                        <input type="text" class="form-control general_deadline_to_day" id="general_deadline_to_day" name="general_deadline_to_day" value="1"/>
                    </div>
                    <label class="col-sm-1 control-label" for="general_deadline_to_day">
                        <span>روز</span>
                    </label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control general_deadline_to_hourmin" id="general_deadline_to_hourmin" name="general_deadline_to_hourmin" value="00:00" />
                    </div>
                    <label class="col-sm-2 control-label" for="general_deadline_to_hourmin">
                        <span>ساعت</span>
                    </label>
                </div>
            </div>
            <!-- [field_group]: end -->
        </div>
        <!-- selection: end / setting: start -->
        <div class="tab-pane fade" id="setting">
            <!-- messaging: start -->
            <div class="well">
                <fieldset>
                    <legend>تنظیمات اطلاع رسانی</legend>
                    <!-- setting_email: start -->
                    <div class="form-group">
                        <div class="checkbox-inline col-sm-2">
                            <label>
                                <input type="checkbox" class="setting_email" id="setting_email" name="setting_email[]" value="is_active">
                                ایمیل
                            </label>
                        </div>
                        <div class="col-sm-10 fg_setting_email">
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_email_users" name="setting_email[]" value="users">
                                    مسئولین
                                </label>
                            </div>
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_email_transcripts" name="setting_email[]" value="transcripts">
                                    رونوشت گیرندگان
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- setting_email: end / setting_sms: start -->
                    <div class="form-group">
                        <div class="checkbox-inline col-sm-2">
                            <label>
                                <input type="checkbox" class="setting_sms" id="setting_sms" name="setting_sms[]" value="is_active">
                                پیامک
                            </label>
                        </div>
                        <div class="col-sm-10 fg_setting_sms">
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_sms_users" name="setting_sms[]" value="users">
                                    مسئولین
                                </label>
                            </div>
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_sms_transcripts" name="setting_sms[]" value="transcripts">
                                    رونوشت گیرندگان
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- setting_sms: end / setting_messaging: start -->
                    <div class="form-group">
                        <div class="checkbox-inline col-sm-2">
                            <label>
                                <input type="checkbox" class="setting_messaging" id="setting_messaging" name="setting_messaging[]" value="is_active">
                                پیام رسان
                            </label>
                        </div>
                        <div class="col-sm-10 fg_setting_messaging">
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_messaging_users" name="setting_messaging[]" value="users">
                                    مسئولین
                                </label>
                            </div>
                            <div class="checkbox-inline">
                                <label>
                                    <input type="checkbox" class="" id="setting_messaging_transcripts" name="setting_messaging[]" value="transcripts">
                                    رونوشت گیرندگان
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- setting_messaging: end -->
                </fieldset>
            </div>
            <br />
            <!-- messaging: start / setting_transferable: start -->
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="" name="setting_transferable" id="setting_transferable" checked="checked">
                    امکان واگذاری به فرد دیگر
                </label>
            </div>
            <!-- setting_transferable: end / setting_end_on_assigner_accept: start -->
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="" name="setting_end_on_assigner_accept" id="setting_end_on_assigner_accept" checked="checked">
                    پایان یافتن با اعلان واگذار کننده
                </label>
            </div>
            <!-- setting_end_on_assigner_accept: end -->
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="" name="setting_rejectable" id="setting_rejectable" checked="checked">
                    اجازه به مسئول، برای نپذیرفتن وظیفه
                </label>
            </div>
            <!-- setting_end_on_assigner_accept: end -->
        </div>
        <!-- setting: end / resources: start -->
        <div class="tab-pane fade" id="resources">
            <h3 style="text-align: center; margin-top: 200px;">این بخش در حال طراحی است.</h3>
        </div>
        <!-- resources: end / rels: start -->
        <div class="tab-pane fade" id="rels">
            <h3 style="text-align: center; margin-top: 200px;">این بخش در حال طراحی است.</h3>
        </div>
        <!-- rels: end / resources: start -->
        <div class="tab-pane fade" id="attachs">
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
        <!-- attachs: end -->
    </div>
    <!-- tabs: end / content: start -->
    <button type="submit" class="submit_form_task_integrate hidden"></button>
</form>
