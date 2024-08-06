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
@else
    <div class="well">موردی برای نمایش وجود ندارد.</div>
@endif
<div class="space-10"></div>
@if($is_final_assigment && !$task_terminate)
    <div id="form_message_box_track" class="form_message_area"></div>
    <form class="form-horizontal form_task_add" id="form_track_task" name="form_track_task">
        <input type="hidden" name="task_id" value="{{@$task_id}}"/>
        <input type="hidden" name="assignment_id" value="{{$assignment_id}}">
        <input type="hidden" name="type" value="response">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="track_description">
                <span>توضیحات</span>
            </label>
            <div class="col-sm-4">
                <textarea type="text" class="form-control" id="track_description" name="description_track" rows="5"></textarea>
                <div class="messages"></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label">
                پیوست فایل
            </label>
            <div class="col-sm-4" id="upload_image">
                <upload_image
                        ref="uploadImage"
                        height="150px"
                        title="بارگزاری تصویر"
                        :default_img_data_json = '{!! $file !!}'
                        :old_default_img_data_json='{{ $old_file }}'
                ></upload_image>
            </div>
        </div>
        <div class="clearfix"></div>
        <button type="submit" id="submit_insert_track" class="hidden"></button>
    </form>

    <form class="form-horizontal form_terminate" id="form_terminate" name="form_terminate">
        <input type="hidden" name="task_id" value="{{@$task_id}}"/>
        <button type="submit" id="submit_terminate" class="hidden"></button>
    </form>
@endif