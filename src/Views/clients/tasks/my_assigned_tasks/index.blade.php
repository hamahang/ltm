@extends(config('laravel_task_manager.task_master'))

@section(config('laravel_task_manager.task_master_yield_content'))
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <!-- right / tabs -->
                            <li class="my_assigned_tasks_tab tabs active" data-tab="my_assigned_tasks_tab"><a href="#my_assigned_tasks_tab" data-toggle="tab"><i class="fa fa-tasks"></i> ارجاعات من</a></li>
                            <li class="my_assigned_tasks_calendar_tab tabs" data-tab="my_assigned_tasks_calendar_tab"><a href="#my_assigned_tasks_calendar_tab" data-toggle="tab"><i class="fa fa-calendar"></i> ارجاعات من در تقویم</a></li>
                            <!-- left / buttons / my_assigned_tasks -->
                            <li class="pull-right my_assigned_tasks_timer" style="margin-right: 10px;">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-xs btn-default my_assigned_tasks_timer_reload" onclick="datatable_reload();">بارگذاری مجدد</button>
                                </div>
                            </li>
                            <!-- left / buttons / my_assigned_tasks_calendar -->
                            <li class="pull-right my_assigned_tasks_calendar_timer" style="margin-right: 10px; display: none;">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-xs btn-default my_assigned_tasks_calendar_timer_reload" onclick="calendar_reload();">بارگذاری مجدد</button>
                                </div>
                            </li>
                            <li class="pull-right" style="margin-right: 10px;"><button class="btn btn-xs btn-default btn_calendar_filter" style="display: none;"><i class="fa fa-filter"></i>&nbsp;فیلتر</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="my_assigned_tasks_tab">
                                <table class="table my_assigned_tasks" id="my_assigned_tasks" width="100%"></table>
                            </div>
                            <div class="tab-pane active" id="my_assigned_tasks_calendar_tab" style="position: relative;">
                                <div class="calendar_filter" data-status="0" style="display: none;">
                                    <div class="row" style="margin-bottom: 25px;">
                                        <div class="col-md-2">
                                            <label class="control-label" for="calendar_filter_code">شناسه</label><br />
                                            <input type="text" class="form-control calendar_filter_code" id="calendar_filter_code" name="calendar_filter_code" value="" style="direction: ltr;">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" for="calendar_filter_subject">موضوع</label><br />
                                            <input type="text" class="form-control calendar_filter_subject" id="calendar_filter_subject" name="calendar_filter_subject" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" for="calendar_filter_title">عنوان</label><br />
                                            <input type="text" class="form-control calendar_filter_title" id="calendar_filter_title" name="calendar_filter_title" value="">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label" for="calendar_filter_employee">ارجاع دهنده</label><br />
                                            <select class="form-control calendar_filter_employee" id="calendar_filter_employee" name="calendar_filter_employee" style="width: 100%;">
                                                <option value="-1" selected="selected">همه</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label" for="calendar_filter_importance">اهمیت</label><br />
                                            <select class="form-control calendar_filter_importance" id="calendar_filter_importance" name="calendar_filter_importance">
                                                <option value="-1">همه</option>
                                                <option value="0">غیر مهم</option>
                                                <option value="1">مهم</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="control-label" for="calendar_filter_immediate">فوریت</label><br />
                                            <select class="form-control calendar_filter_immediate" id="calendar_filter_immediate" name="calendar_filter_immediate">
                                                <option value="-1">همه</option>
                                                <option value="0">غیر فوری</option>
                                                <option value="1">فوری</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary pull-right btn_calendar_filter_apply" style="margin-right: 10px;">اعمال</button>
                                    <button class="btn btn-default pull-right btn_calendar_filter_clear">لغو</button>
                                    <div style="clear: both;"></div>
                                    <hr />
                                </div>
                                <div class="my_assigned_tasks_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section(config('laravel_task_manager.task_master_yield_inline_style'))
    @include('laravel_task_manager::clients.tasks.my_assigned_tasks.helper.style')
@stop

@section(config('laravel_task_manager.task_master_yield_footer_inline_javascript'))
    @include('laravel_task_manager::clients.tasks.my_assigned_tasks.helper.script')
@stop
