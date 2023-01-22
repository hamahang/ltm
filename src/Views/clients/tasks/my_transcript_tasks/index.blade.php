@extends(config('laravel_task_manager.task_master'))

@section(config('laravel_task_manager.task_master_yield_content'))
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <!-- right / tabs -->
                            <li class="my_transcript_tasks_tab tabs active"><a href="#my_transcript_tasks_tab" data-toggle="tab"><i class="fa fa-bars"></i> رونوشت‌های من</a></li>
                            <li class="my_transcript_tasks_trash_tab tabs"><a href="#my_transcript_tasks_trash_tab" data-toggle="tab"><i class="fa fa-trash-o"></i> حذف شده</a></li>
                            <li class="my_transcript_tasks_calendar_tab tabs" data-tab="my_transcript_tasks_calendar_tab"><a href="#my_transcript_tasks_calendar_tab" data-toggle="tab"><i class="fa fa-calendar"></i> رونوشت‌های من در تقویم</a></li>
                            <!-- left / buttons / transcripts -->
                            <li class="pull-right my_transcript_tasks_buttons btn_trash_reload" style="margin-right: 10px;"><button type="button" class="btn btn-xs btn-default" onclick="datatable_reload();">بارگذاری مجدد</button></li>
                            <li class="pull-right my_transcript_tasks_buttons btn_trash" style="margin-right: 10px;"><button class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i> انتقال به سطل زباله</button></li>
                            <!-- left / buttons / transcripts_trash -->
                            <li class="pull-right my_transcript_tasks_trash_buttons btn_reload" style="margin-right: 10px; display: none;"><button type="button" class="btn btn-xs btn-default" onclick="datatable_reload_trash();">بارگذاری مجدد</button></li>
                            <li class="pull-right my_transcript_tasks_trash_buttons btn_delete" style="margin-right: 10px; display: none;"><button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> حذف دائم</button></li>
                            <li class="pull-right my_transcript_tasks_trash_buttons btn_restore" style="margin-right: 10px; display: none;"><button class="btn btn-xs btn-success"><i class="fa fa-recycle"></i> بازگردانی</button></li>
                            <!-- left / buttons / transcripts_calendar -->
                            <li class="pull-right my_transcript_tasks_calendar_buttons btn_calendar_reload" style="margin-right: 10px; display: none;"><button type="button" class="btn btn-xs btn-default" onclick="calendar_reload();">بارگذاری مجدد</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="my_transcript_tasks_tab">
                                <table class="table my_transcript_tasks" id="my_transcript_tasks" width="100%"></table>
                            </div>
                            <div class="tab-pane" id="my_transcript_tasks_trash_tab">
                                <table class="table my_transcript_tasks_trash" id="my_transcript_tasks_trash" width="100%"></table>
                            </div>
                            <div class="tab-pane" id="my_transcript_tasks_calendar_tab" style="position: relative;">
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
                                            <label class="control-label" for="calendar_filter_assigner">ارجاع دهنده</label><br />
                                            <select class="form-control calendar_filter_assigner" id="calendar_filter_assigner" name="calendar_filter_assigner" style="width: 100%;">
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
                                <div class="my_transcript_tasks_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section(config('laravel_task_manager.task_master_yield_footer_inline_javascript'))
    @include('laravel_task_manager::clients.tasks.my_transcript_tasks.helper.common')
    @include('laravel_task_manager::clients.tasks.my_transcript_tasks.helper.script')
    @include('laravel_task_manager::clients.tasks.my_transcript_tasks.helper.script_trash')
@stop
