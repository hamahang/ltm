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
<form class="form-horizontal form_action" id="form_action" name="form_action">
    <input type="hidden" class="task_id" id="task_id" name="task_id" value="{!! ltm_encode_ids([$task->id]) !!}" />
    <input type="hidden" class="task_assignment_id" id="task_assignment_id" name="task_assignment_id" value="{!! ltm_encode_ids([$assignment->id]) !!}" />
    <input type="hidden" class="action_do_status_old" id="action_do_status_old" name="action_do_status_old" value="{!! $task->assignment->statuses->first()->status !!}" />
    <input type="hidden" class="action_do_status_percent_old" id="action_do_status_percent_old" name="action_do_status_percent_old" value="{!! $task->assignment->statuses->first()->percent !!}" />
    <input type="hidden" class="action_do_importance_old" id="action_do_importance_old" name="action_do_importance_old" value="{!! $task->assigner_priority->importance !!}" />
    <input type="hidden" class="action_do_immediate_old" id="action_do_immediate_old" name="action_do_immediate_old" value="{!! $task->assigner_priority->immediate !!}" />
    <input type="hidden" class="action_type" id="action_type" name="action_type" value="-1" />
    <div class="container col-md-12">
        <ul class="nav nav-tabs">
            <li class="tabs{!! 'details' == $default_tab ? ' active' : null !!}" data-tab-id="details"><a data-toggle="tab" href="#details">جزئیات</a></li>
            <li class="tabs{!! 'transcripts' == $default_tab ? ' active' : null !!}" data-tab-id="transcripts"><a data-toggle="tab" href="#transcripts">رونوشت&zwnj;ها</a></li>
            <li class="tabs{!! 'attachs' == $default_tab ? ' active' : null !!}" data-tab-id="attachs"><a data-toggle="tab" href="#attachs">پیوست&zwnj;ها</a></li>
            <li class="tabs{!! 'action' == $default_tab ? ' active' : null !!}" data-tab-id="action"><a data-toggle="tab" href="#action" style="color: #4caf50;">اقدام</a></li>
            <li class="tabs{!! 'history' == $default_tab ? ' active' : null !!} pull-right" data-tab-id="history"><a data-toggle="tab" href="#history">تاریخچه</a></li>
        </ul>
        <div class="tab-content">
            <div id="details" class="tab-pane fade {!! 'details' == $default_tab ? 'in active' : null !!}">
                <table class="table table-striped">
                    <tr style="font-weight: bold;">
                        <td class="col-md-2">شناسه</td>
                        <td class="col-md-10">{!! $task->code ? : 'درج نشده' !!}</td>
                    </tr>
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
                <input type="hidden" class="action_do_status" name="action_do_status" value="-1" />
                <table class="table table-striped">
                    <!-- action_do_status: start -->
                    <tr>
                        <td class="col-md-2">وضعیت</td>
                        <td class="col-md-10">
                            @if ($progress['is_creator'])
                                @if ($assignment->confirmation)
                                    <div style="margin-top: 0; font-weight: bold;">{!! config('tasks.statuses.31') !!}</div>
                                @else
                                    <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_m1"><input type="radio" class="action_do_status" id="action_do_status_m1" name="action_do_status" value="-1" checked="checked" />{!! config('tasks.statuses.-1') !!}</label></div>
                                    @if ($assignment->next_assignment)
                                        @if ($assignment->next_assignment->confirmation)
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_31"><input type="radio" class="action_do_status" id="action_do_status_31" name="action_do_status" value="31" />{!! config('tasks.statuses.31') !!}</label></div>
                                        @else
                                            <div class="radio-inline" style="margin-top: 0; font-weight: bold;">{!! config('tasks.statuses.50') . ' ' . $progress['employee']->full_name !!}</div>
                                        @endif
                                    @else
                                        @if (2 == $assignment->current_status->status)
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_31"><input type="radio" class="action_do_status" id="action_do_status_31" name="action_do_status" value="31" />{!! config('tasks.statuses.31') !!}</label></div>
                                        @else
                                            <div class="radio-inline" style="margin-top: 0; font-weight: bold;">{!! config('tasks.statuses.50') . ' ' . $progress['employee']->full_name !!}</div>
                                        @endif
                                    @endif
                                    <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_4"><input type="radio" class="action_do_status" id="action_do_status_4" name="action_do_status" value="4" disabled="disabled" />{!! config('tasks.statuses.4') !!}</label></div>
                                @endif
                            @else
                                @if ($assignment->confirmation)
                                    <div style="margin-top: 0; font-weight: bold;">تائید شده</div>
                                @else
                                    @if ($assignment->next_assignment)
                                        @if ($assignment->next_assignment->confirmation)
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_m1"><input type="radio" class="action_do_status" id="action_do_status_m1" name="action_do_status" value="-1" checked="checked" />{!! config('tasks.statuses.-1') !!}</label></div>
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_3"><input type="radio" class="action_do_status" id="action_do_status_3" name="action_do_status" value="3" />{!! config('tasks.statuses.3') !!}</label></div>
                                        @else
                                            <div style="margin-top: 0; font-weight: bold;">{!! config('tasks.statuses.50') . ' ' . $progress['employee']->full_name !!}</div>
                                        @endif
                                    @else
                                        @if (2 == $assignment->current_status->status)
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_m1"><input type="radio" class="action_do_status" id="action_do_status_m1" name="action_do_status" value="-1" checked="checked" />{!! config('tasks.statuses.-1') !!}</label></div>
                                            <div class="radio-inline" style="margin-top: 5px;"><label for="action_do_status_3"><input type="radio" class="action_do_status" id="action_do_status_3" name="action_do_status" value="3" />{!! config('tasks.statuses.3') !!}</label></div>
                                        @else
                                            <div style="margin-top: 0; font-weight: bold;">{!! config('tasks.statuses.50') . ' ' . $progress['employee']->full_name !!}</div>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                    <!-- action_do_status: end / action_do_importance: start -->
                    <tr>
                        <td class="col-md-2">اهمیت از نظر شما</td>
                        <td class="col-md-10">
                            <div class="radio-inline"><label for="action_do_importance_0"><input type="radio" id="action_do_importance_0" name="action_do_importance" value="0" value="3" @if (0 == $task->assigner_priority->importance)checked="checked" @endif/>غیر مهم</label></div>
                            <div class="radio-inline"><label for="action_do_importance_1"><input type="radio" id="action_do_importance_1" name="action_do_importance" value="1" value="3" @if (1 == $task->assigner_priority->importance)checked="checked" @endif/>مهم</label></div>
                        </td>
                    </tr>
                    <!-- action_do_importance: end / action_do_immediate: start -->
                    <tr>
                        <td class="col-md-2">فوریت از نظر شما</td>
                        <td class="col-md-10">
                            <div class="radio-inline"><label for="action_do_immediate_0"><input type="radio" id="action_do_immediate_0" name="action_do_immediate" value="0" @if (0 == $task->assigner_priority->immediate)checked="checked" @endif/>غیر فوری</label></div>
                            <div class="radio-inline"><label for="action_do_immediate_1"><input type="radio" id="action_do_immediate_1" name="action_do_immediate" value="1" @if (1 == $task->assigner_priority->immediate)checked="checked" @endif/>فوری</label></div>
                        </td>
                    </tr>
                    <!-- action_do_immediate: end -->
                </table>
            </div>
            <div id="history" class="tab-pane fade {!! 'history' == $default_tab ? 'in active' : null !!}">
                <!-- Timeline -->
                @if ($task->logs->count())
                <div class="timeline timeline-left">
                    <div class="timeline-container">
                        <div class="timeline-date text-muted">
                            <i class="icon-history position-left"></i> <span class="text-semibold">Monday</span>, April 18
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
    <button type="submit" class="submit_form_action hidden"></button>
</form>





