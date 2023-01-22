@extends(config('laravel_task_manager.task_master'))

@section('plugin_js')

@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <div class="row">
                        <h6 class="col-xs-8 panel-title">
                            تنظیمات اطلاع رسانی
                        </h6>
                        <span style="float: left;">
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">تنظیمات ارسال</div>
                        <div class="panel-body">
                            @include('laravel_task_manager::backend.settings.view.send_notify')
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">تنظیمات دریافت</div>
                        <div class="panel-body">
                            @include('laravel_task_manager::backend.settings.view.recive_notify')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_inline_javascript')
    @include('laravel_task_manager::backend.settings.helper.script')
@stop