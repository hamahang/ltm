<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title')</title>

    <!-- Global stylesheets -->
    @include('laravel_task_manager::layouts.backend.limitless_v16.helpers.stylesheets.global')
    <!-- /global stylesheets -->
    @yield('plugin_css')
    @yield('inline_style')

    <!-- Core JS files -->
    @include('laravel_task_manager::layouts.backend.limitless_v16.helpers.javascripts.core')
    <!-- /core JS files -->

    @yield('plugin_js')
    @yield('inline_javascript')
</head>

<body class="navbar-top">
<!-- Main navbar -->
@include('laravel_task_manager::layouts.backend.limitless_v16.helpers.main_navbar')
<!-- /main navbar -->

<!-- Page container -->
@include('laravel_task_manager::layouts.backend.limitless_v16.helpers.page_container')
<!-- /page container -->

<!-- ---------------------------------------- ****_Modals_**** -------------------------------------------- -->
@yield('modals')
<!-- ------------------------------------------ ************ ---------------------------------------------- -->

@yield('footer_plugin_js')
@yield('footer_inline_javascript')
</body>
</html>
