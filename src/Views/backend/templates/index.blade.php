@extends(config('laravel_task_manager.task_master'))
@section('plugin_css')
@stop
@section('theme_plugin_js')
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/headroom/headroom.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/headroom/headroom_jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/ui/nicescroll.min.js')}}"></script>
    <script src="http://cdn.jsdelivr.net/npm/jquery.fancytree@2.27/dist/jquery.fancytree-all-deps.min.js"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/velocity/velocity.ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/spin.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/buttons/ladda.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/uploaders/fileinput/plugins/purify.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('layouts/limitless.v16/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>

    {{--notifications--}}
    <script type="text/javascript" src="{{url('layouts/limitless.v16/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script type="text/javascript" src="{{url('layouts/limitless.v16/js/plugins/notifications/noty.min.js')}}"></script>
    <script type="text/javascript" src="{{url('layouts/limitless.v16/js/plugins/notifications/jgrowl.min.js')}}"></script>
    {{--/notifications--}}
@stop
@section('js_page')
@stop
@section('breadcrumb')
    <li><a href="{{route('ltm.clients.dashboard')}}"><i class="icon-home2 position-left"></i>داشبورد</a></li>
    <li class="active">قالب</li>
@stop
@section('content')
    <div class="panel panel-flat">

        <div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#template-tab1" data-toggle="tab">قالب مدیریت</a></li>
                    <li><a href="#template-tab2" data-toggle="tab">قالب کاربر</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="template-tab1">
                        @include('laravel_task_manager::backend.templates.management_template.index')
                    </div>

                    <div class="tab-pane" id="template-tab2">
                        @include('laravel_task_manager::backend.templates.user_template.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('modals')
    {!! $logo_manager['modal_content'] !!}
    {!! $logo_user['modal_content'] !!}
@stop
@section('footer_inline_javascript')
    @include('laravel_task_manager::backend.templates.helper.index_inline_js')
@stop