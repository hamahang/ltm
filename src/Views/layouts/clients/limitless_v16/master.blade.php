<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield(config('laravel_task_manager.task_master_yield_page_title'))</title>
    <script type="text/javascript" src="{{ asset('vendor/laravel_task_manager/build/common/js/common.js') }}"></script>

    <!-- Global stylesheets -->
    @include('laravel_task_manager::layouts.clients.limitless_v16.helpers.stylesheets.global')
    <!-- /global stylesheets -->
    @yield(config('laravel_task_manager.task_master_yield_plugin_css'))
    @yield(config('laravel_task_manager.task_master_yield_inline_style'))

    <!-- Core JS files -->
    @include('laravel_task_manager::layouts.clients.limitless_v16.helpers.javascripts.core')
    <!-- /core JS files -->

    @yield(config('laravel_task_manager.task_master_yield_plugin_js'))
    @yield(config('laravel_task_manager.task_master_yield_inline_javascript'))
</head>

<body class="navbar-top">

<!-- Main navbar -->
@include('laravel_task_manager::layouts.clients.limitless_v16.helpers.main_navbar')
<!-- /main navbar -->

<!-- Page container -->
@include('laravel_task_manager::layouts.clients.limitless_v16.helpers.page_container')
<!-- /page container -->

<!-- ---------------------------------------- ****_Modals_**** -------------------------------------------- -->
@yield(config('laravel_task_manager.task_master_yield_modals'))
<!-- ------------------------------------------ ************ ---------------------------------------------- -->

@yield(config('laravel_task_manager.task_master_yield_footer_plugin_js'))
@yield(config('laravel_task_manager.task_master_yield_footer_inline_javascript'))
</body>
</html>
