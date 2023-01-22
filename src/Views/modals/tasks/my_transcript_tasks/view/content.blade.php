@include('laravel_task_manager::modals.tasks.progress.transcript.template')
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
    <div class="container col-md-12">
        <ul class="nav nav-tabs">
            <li class="tabs{!! 'details' == $default_tab ? ' active' : null !!}" data-tab-id="details"><a data-toggle="tab" href="#details">جزئیات</a></li>
            <li class="tabs{!! 'transcripts' == $default_tab ? ' active' : null !!}" data-tab-id="transcripts"><a data-toggle="tab" href="#transcripts">رونوشت&zwnj;ها</a></li>
            <li class="tabs{!! 'attachs' == $default_tab ? ' active' : null !!}" data-tab-id="attachs"><a data-toggle="tab" href="#attachs">پیوست&zwnj;ها</a></li>
            <li class="tabs{!! 'history' == $default_tab ? ' active' : null !!} pull-right" data-tab-id="history"><a data-toggle="tab" href="#history">تاریخچه</a></li>
        </ul>
        <div class="tab-content">
            <div id="details" class="tab-pane fade {!! 'details' == $default_tab ? 'in active' : null !!}">
                <table class="table table-striped">
                    {{--
                    <!-- assigner -->
                    <tr>
                        <td class="col-md-2" rowspan="2">ارجاع دهنده</td>
                        <td class="col-md-1" rowspan="2">{!! $task->assignment->assigner->avatar64 !!}</td>
                        <td class="col-md-3">{!! $task->assignment->assigner->full_name !!}</td>
                        <td class="col-md-2"></td>
                        <td class="col-md-4">{!! $importances[$task->assigner_priority->importance] !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-3">{!! $task->assignment->assigner->username !!}</td>
                        <td class="col-md-1" style="border: none;"></td>
                        <td class="col-md-4">{!! $immediates[$task->assigner_priority->immediate] !!}</td>
                    </tr>
                    <!-- employee -->
                    <tr>
                        <td class="col-md-2" rowspan="2">مسئول</td>
                        <td class="col-md-1" rowspan="2">{!! $task->assignment->employee->avatar64 !!}</td>
                        <td class="col-md-3">{!! $task->assignment->employee->full_name !!}</td>
                        <td class="col-md-2"></td>
                        <td class="col-md-4">{!! $importances[$task->employee_priority->importance] !!}</td>
                    </tr>
                    <tr>
                        <td class="col-md-3">{!! $task->assignment->employee->username !!}</td>
                        <td class="col-md-1" style="border: none;"></td>
                        <td class="col-md-4">{!! $immediates[$task->employee_priority->immediate] !!}</td>
                    </tr>
                    <!-- -->
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
                        {{--
                        <div class="timeline-row">
                            <div class="timeline-icon">
                                <img src="assets/images/placeholder.jpg" alt="">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-flat timeline-content">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">Himalayan sunset</h6>
                                            <div class="heading-elements">
                                                <span class="heading-text"><i class="icon-checkmark-circle position-left text-success"></i> 49 minutes ago</span>
                                                <ul class="icons-list">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                            <i class="icon-arrow-down12"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="#"><i class="icon-user-lock"></i> Hide user posts</a></li>
                                                            <li><a href="#"><i class="icon-user-block"></i> Block user</a></li>
                                                            <li><a href="#"><i class="icon-user-minus"></i> Unfollow user</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#"><i class="icon-embed"></i> Embed post</a></li>
                                                            <li><a href="#"><i class="icon-blocked"></i> Report this post</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <a href="#" class="display-block content-group">
                                                <img src="assets/images/cover.jpg" class="img-responsive content-group" alt="">
                                            </a>
                                            <h6 class="content-group">
                                                <i class="icon-comment-discussion position-left"></i>
                                                <a href="#">Jason Ansley</a> commented:
                                            </h6>
                                            <blockquote>
                                                <p>When suspiciously goodness labrador understood rethought yawned grew piously endearingly inarticulate oh goodness jeez trout distinct hence cobra despite taped laughed the much audacious less inside tiger groaned darn stuffily metaphoric unihibitedly inside cobra.</p>
                                                <footer>Jason, <cite title="Source Title">10:39 am</cite></footer>
                                            </blockquote>
                                        </div>
                                        <div class="panel-footer panel-footer-transparent">
                                            <div class="heading-elements">
                                                <ul class="list-inline list-inline-condensed heading-text">
                                                    <li><a href="#" class="text-default"><i class="icon-eye4 position-left"></i> 438</a></li>
                                                    <li><a href="#" class="text-default"><i class="icon-comment-discussion position-left"></i> 71</a></li>
                                                </ul>
                                                <span class="heading-btn pull-right">
											<a href="#" class="btn btn-link">Read post <i class="icon-arrow-left13 position-right"></i></a>
										</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        --}}
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
