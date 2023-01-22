<div class="space-10"></div>
<div class="container col-md-12">
    <div id="details" class="">
        <table class="table table-striped">
            <tr>
                <td class="col-md-2">شماره پرونده</td>
                <td class="col-md-10" colspan="4" style="text-align: justify;">
                    {!! ltm_html_file_no_creator($task->file_no) !!}
                </td>
            </tr>
            @if(isset($task->step_name) && $task->step_name)
                <tr>

                    <td class="col-md-2">گام</td>
                    <td class="col-md-10" colspan="4" style="text-align: justify;">
                        {{$task->step_name}}
                    </td>
                </tr>
            @endif
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
    <div id="history" class="">
        <div class="space-10"></div>
        <!-- Timeline -->
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
            </div>
        @else
            <div class="well">موردی برای نمایش وجود ندارد.</div>
    @endif
    <hr>
    <!-- /timeline -->
    </div>
    <div id="response">
        <div id="form_message_box_track_{{$variable}}" class="form_message_area"></div>
        <form class="form-horizontal form_task_add" id="form_track_task_{{$variable}}" name="form_task_add">
            <input type="hidden" name="request_id" value="{{$request_id}}">
            <input type="hidden" name="assignment_id" value="{{$assignment_id}}">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="track_description">
                    <span>توضیحات</span>
                </label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" id="track_description" name="description" rows="5"></textarea>
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
                            $('#result_track').html(result.attachment_track.view.medium) ;
                        }
                    </script>
                    {!! $lfm_track['button'] !!}
                    {!! $lfm_track['modal_content'] !!}
                    <div style="float: left" id="result_track"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <button type="submit" id="submit_insert_track_task_{{$variable}}" class="submit_form_task_add hidden"></button>
        </form>
    </div>
</div>
@include('laravel_task_manager::clients.tasks.panels.jspanel.helpers.jspanel_track_script')
