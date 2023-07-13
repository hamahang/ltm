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
<script>
    String.prototype.nums_to_en = function()
    {
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(fa[i], en[i]);
        }
        return r;
    };
    String.prototype.nums_to_fa = function()
    {
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(en[i], fa[i]);
        }
        return r;
    };
</script>
@yield(config('laravel_task_manager.task_master_yield_footer_plugin_js'))
@yield(config('laravel_task_manager.task_master_yield_footer_inline_javascript'))
</body>
</html>
