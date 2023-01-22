<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html">
            <img src="{{asset('vendor/laravel_task_manager/images/logo_light.png')}}" alt="">
        </a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav navbar-right">
            <!-- temporary -->
            <li class="pull-left" style="margin: 2px 0 0 5px;">
                <select class="form-control" style="margin-top: 3px;" onchange="window.location.href = '/ltm/login_by_id/' + $(this).find(':selected').val() + '/' + $('.noname_class_n3xqjlydol').find(':selected').val();">
                    @php ($users = config('laravel_task_manager.user_model')::all())
                    @forelse ($users as $user)
                        <option value="{!! $user->id !!}" @if ($user->id == auth()->id()) selected="selected" @endif>{!! $user->full_name !!}</option>
                    @empty
                    @endforelse
                </select>
            </li>
            <li class="pull-left noname_class_n3xqjlydol" style="margin: 2px 0 0 25px;">
                <select class="form-control" style="margin-top: 3px;">
                    <option value="ltm.clients.dashboard">داشبورد</option>
                    <option value="clients.tasks.my_tasks">وظایف من</option>
                    <option value="clients.tasks.my_assigned_tasks">ارجاعات من</option>
                    <option value="clients.tasks.my_transcript_tasks">رونوشت‌های من</option>
                </select>
            </li>
            @php ($users = config('laravel_task_manager.user_model')::all())
            <!-- /temporary -->
            <li style="margin-left: 5px;">
                {!! ltm_create_task_button() !!}
            </li>
            <li class="dropdown dropdown-user" style="width: 180px;">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/vendor/laravel_task_manager/images/placeholder.jpg" alt="">
                    <span>{!! auth()->user()->full_name !!}</span>
                    <i class="caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
                    <li><a href="#"><span class="badge bg-teal-400 pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                    <li><a href="{!! route(config('laravel_task_manager.logout_route')) !!}"><i class="icon-switch2"></i> خروج</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>