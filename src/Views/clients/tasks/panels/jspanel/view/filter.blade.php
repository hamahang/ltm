<div class="space-10"></div>
<span class="btn_filter_datatables" style="cursor: pointer; position: absolute;left:5px;top:-45px"><i class="fa fa-filter"></i></span>
<div class="forms_datatable_filters" style="@if(!$request_id) display:none ;@endif ">
    <div style="background-color: #eeeeee9e">
        <form class="form-horizontal"id="frm_filter_request" >
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label label_post text-right" for="value">
                        <span class="more_info"></span>
                        <span class="label_company_owner_type">فیلتر شماره پرونده :</span>
                    </label>
                    <div class="col-sm-12">
                        <select id="filter_file_no" class="form-control select" name="filter_file_no">
                            @if($request_id)
                                <option value="{{$request_id}}">{{$request_id}}</option>
                            @else
                                <option></option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 messages"></div>
                </div>
            </div>
            @if(is_array($step) || !$step)
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="col-sm-12 control-label label_post text-right" for="value">
                            <span class="more_info"></span>
                            <span class="label_company_owner_type">فیلتر گام :</span>
                        </label>
                        <div class="col-sm-12">
                            <select id="filter_step_id" class="form-control select" name="filter_step_id">
                                @if($step && isset($request_id) && $request_id)
                                    <option value="{{$step['id']}}">{{$step['title']}}</option>
                                @else
                                    <option></option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-12 messages"></div>
                    </div>
                </div>
            @endif
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-sm-12 control-label label_post text-right" for="value"> </label>
                    <div class="col-sm-12 text-left">
                        <button type="button" id="cancel_filter_data" class="btn bg-teal-400 btn-labeled"><span>لغو</span></button>
                        <button type="button" id="filter_data" class="btn bg-info btn-labeled"><span>اعمال</span></button>
                    </div>
                </div>
            </div>

        </form>
        <div class="clearfixed"></div>
    </div>
    <div class="space-5"></div>
    <div class="hr"></div>
    <div class="space-10"></div>
</div>
<div class="clearfix"></div>
@include('laravel_task_manager::clients.tasks.panels.jspanel.helpers.filter_script')



