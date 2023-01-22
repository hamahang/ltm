<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
            <!-- Main -->
            <li class="navigation-header"><span>فهرست اصلی:</span> <i class="icon-menu" title="Main pages"></i></li>
            <li @if(Route::currentRouteName() == config('laravel_task_manager.site_dashboard_route')) class="active"@endif><a href="{{route(config('laravel_task_manager.site_dashboard_route'))}}"><i class="icon-home4"></i> <span>داشبورد</span></a></li>
            <li @if(in_array(Route::currentRouteName(),[config('laravel_task_manager.site_transcripted_task_route'),config('laravel_task_manager.site_assigned_task_route'),config('laravel_task_manager.site_my_task_route')]) == 'ltm.clients.dashboard') class="active"@endif>
                <a href="#"><i class="icon-stack2"></i> <span>وظایف</span></a>
                <ul>
                    <li @if(Route::currentRouteName() == config('laravel_task_manager.site_my_task_route')) class="active"@endif><a href="{!! route(config('laravel_task_manager.site_my_task_route')) !!}">وظایف من</a></li>
                    <li @if(Route::currentRouteName() == config('laravel_task_manager.site_assigned_task_route')) class="active"@endif><a href="{!! route(config('laravel_task_manager.site_assigned_task_route'))!!}">ارجاعات من</a></li>
                    <li @if(Route::currentRouteName() == config('laravel_task_manager.site_transcripted_task_route')) class="active"@endif><a href="{!! route(config('laravel_task_manager.site_transcripted_task_route'))!!}">رونوشت&zwnj;های من</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>