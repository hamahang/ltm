<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">

            <!-- Main -->
            <li class="navigation-header"><span>فهرست اصلی:</span> <i class="icon-menu" title="Main pages"></i></li>

            @if(Route::currentRouteName() == 'ltm.clients.dashboard')
                @php($active_dashboard = 'active')
            @else
                @php($active_dashboard = '')
            @endif
            <li class="{{$active_dashboard}}" ><a href="{{route('backend.dashboard')}}"><i class="icon-home4"></i> <span>داشبورد</span></a></li>

            @if(Route::currentRouteName() == 'ltm.backend.subjects.index')
                @php($active_my_task = 'active')
            @else
                @php($active_my_task = '')
            @endif
            <li class="{{$active_my_task}}" ><a href="{{route('ltm.backend.subjects.index')}}"><i class="icon-bubble-dots4"></i> <span>مدیریت موضوعات</span></a></li>

            @if(Route::currentRouteName() == 'ltm.backend.templates.index')
                @php($active_templates = 'active')
            @else
                @php($active_templates = '')
            @endif
            <li class="{{$active_templates}}" ><a href="{{route('ltm.backend.templates.index')}}"><i class="icon-insert-template"></i> <span>مدیریت قالب</span></a></li>

            @if(Route::currentRouteName() == 'backend.users.index')
                @php($active_users = 'active')
            @else
                @php($active_users = '')
            @endif
            <li class="{{$active_users}}" ><a href="{{route('backend.users.index')}}"><i class="icon-users4"></i> <span>مدیریت کاربران</span></a></li>
            <!-- /page kits -->

        </ul>
    </div>
</div>