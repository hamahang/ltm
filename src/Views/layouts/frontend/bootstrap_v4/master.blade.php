<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title','Hamahang-Co')</title>

    <!-- Bootstrap CSS -->
    @include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.css.core_css')
    <!-- Optional CSS -->
    @yield('plugin_css')
    @yield('inline_css')

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.js.core_js')

    <!-- Optional JavaScript -->
    @yield('plugin_js')
    @yield('inline_js')
</head>
<body>
@include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.sections.responsive_menu.menu_responsive')
<div id="main">
    <div id="main_shadow"></div>
    @include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.sections.header')
    @include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.sections.client_menu')
    <div class="container main_content">
        @yield('content')
    </div>
    @include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.sections.footer')
</div>
<!-- Optional JavaScript -->
@yield('footer_plugin_js')
@yield('footer_inline_js')
@include('laravel_task_manager::layouts.frontend.bootstrap_v4.helpers.sections.responsive_menu.menu_responsive_js')
<div id="all_modals"></div>

</body>
</html>
