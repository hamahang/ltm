@extends(config('laravel_task_manager.task_master'))
@section(config('laravel_task_manager.task_master_yield_plugin_js'))
    <script type="text/javascript" src="{{asset('vendor/laravel_task_manager/build/backend/js/dashboard.min.js')}}"></script>
@stop
@section(config('laravel_task_manager.task_master_yield_breadcrumb'))
    <li class="active">داشبورد</li>
@stop
@section(config('laravel_task_manager.task_master_yield_content'))
    <div class="row">
        <div class="col-lg-3">
            <a href="http://freezones.hamahang-co.ir/backend/sms_admin">
                <div class="panel bg-blue-800">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <i class="fa fa-envelope fa-4x" style="color: white;"></i>
                        </div>
                        <h3 class="no-margin">547</h3>
                        <div class="space-8"></div>
                        <span>تعداد پیامک های قابل استفاده</span>
                    </div>

                    <div class="container-fluid">
                        <div class="chart" id="members-online"></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="http://freezones.hamahang-co.ir/backend/sys_requests">
                <div class="panel bg-indigo-800">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <i class="fa fa-users fa-4x" style="color: white;"></i>
                        </div>
                        <h3 class="no-margin">54</h3>
                        <div class="space-8"></div>
                        <span>تعداد متقاضی</span>
                    </div>

                    <div class="container-fluid">
                        <div class="chart" id="members-online"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-flat border-top-info">
                <div class="panel-heading">
                    <h6 class="panel-title">دسترسی سریع</h6>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="panel-body">
                            <div class="panel bg-orange-400">
                                <div class="panel-body links_font_color">
                                    <a href="{{route('ltm.backend.subjects.index')}}"><h6 class="no-margin"><i class="fa fa-gears"></i> مدیریت موضوعات</h6></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
