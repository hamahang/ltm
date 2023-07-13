<form class="form-horizontal form_subject" id="form_subject" name="form_subject">
    <!-- tabs: start -->
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#general">تنظیمات نمایش پرونده</a></li>
        <li><a data-toggle="tab" href="#view"> تنظیمات اتصال نمایش لیست پرونده ها</a></li>
    </ul>
    <!-- tabs: end / content: start -->
    <div class="tab-content">
        <!-- general: start -->
        <div class="tab-pane fade in active" id="general">
            <input type="text" class="form-control subject_id hide" value="{{ltm_encode_ids([$Subject->id])}}" name="subject_id"/>
            <div class="form-group fg_url col-xs-12">
                <label class="col-sm-3 control-label" for="url">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">آدرس </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingShow)
                        <input type="text" name="url" class="form-control" value="{{$SubjectSettingShow->url}}"/>
                    @else
                        <input type="text" name="url" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_token col-xs-12">
                <label class="col-sm-3 control-label" for="token">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">توکن </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingShow)
                        <input type="text" name="token" class="form-control" value="{{$SubjectSettingShow->token}}"/>
                    @else
                        <input type="text" name="token" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_report col-xs-12">
                <label class="col-sm-3 control-label" for="report">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">کد گزارش </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingShow)
                        <input type="text" name="report" class="form-control" value="{{$SubjectSettingShow->report_id}}"/>
                    @else
                        <input type="text" name="report" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_template col-xs-12">
                <label class="col-sm-3 control-label" for="template">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">کد قالب </span>
                </label>
                <div class="col-sm-5">
                    <select type="text" class="form-control select2 template" multiple="true" name="template[]">
                        @if($SubjectSettingShow)
                            @foreach(explode(',',$SubjectSettingShow->template_id) as $param))
                            <option selected="selected" value="{{$param}}">{{$param}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_column col-xs-12">
                <label class="col-sm-3 control-label" for="column">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">شماره فیلد </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingShow)
                        <input type="text" name="column" class="form-control" value="{{$SubjectSettingShow->column_id}}"/>
                    @else
                        <input type="text" name="column" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="view">
            <div class="form-group fg_url_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="url_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">آدرس </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingGet)
                        <input type="text" name="url_get_list" class="form-control" value="{{$SubjectSettingGet->url}}"/>
                    @else
                        <input type="text" name="url_get_list" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_token_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="token_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">توکن </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingGet)
                        <input type="text" name="token_get_list" class="form-control" value="{{$SubjectSettingGet->token}}"/>
                    @else
                        <input type="text" name="token_get_list" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_report_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="report_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">کد گزارش </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingGet)
                        <input type="text" name="report_get_list" class="form-control" value="{{$SubjectSettingGet->report_id}}"/>
                    @else
                        <input type="text" name="report_get_list" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_template_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="template_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">کد قالب </span>
                </label>
                <div class="col-sm-5">
                    <select type="text" class="form-control select2 template_get_list" multiple="true" name="template_get_list[]">
                        @if($SubjectSettingGet)
                            @foreach(explode(',',$SubjectSettingGet->template_id) as $param))
                            <option selected="selected" value="{{$param}}">{{$param}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_column_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="column_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">شماره فیلد </span>
                </label>
                <div class="col-sm-5">
                    @if($SubjectSettingGet)
                        <input type="text" name="column_get_list" class="form-control" value="{{$SubjectSettingGet->column_id}}"/>
                    @else
                        <input type="text" name="column_get_list" class="form-control"/>
                    @endif
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
            <div class="form-group fg_column_concat_get_list col-xs-12">
                <label class="col-sm-3 control-label" for="column_concat_get_list">
                    <span class="more_info"></span>
                    <span class="red_star">*</span>
                    <span class="label_title">ترکیب شماره فیلد ها </span>
                </label>
                <div class="col-sm-5">
                    <select type="text" class="form-control select2 column_concat_get_list" multiple="true" name="column_concat_get_list[]">
                        @if($SubjectSettingGet)
                            @foreach(explode(',',$SubjectSettingGet->column_concat) as $param))
                            <option selected="selected" value="{{$param}}">{{$param}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-4 messages"></div>
            </div>
        </div>
    </div>
    <!-- tabs: end / content: start -->
    <div class="form-group fg_submit clearfixed">
        <div class="col-sm-5 col-sm-offset-3">
            <button type="submit" name="submit" class="btn btn-success hide" id="form_subject_submit">{{trans('common.form.save')}}</button>
        </div>
    </div>
</form>
