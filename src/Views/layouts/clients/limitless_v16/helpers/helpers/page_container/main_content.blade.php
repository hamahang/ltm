<div class="content-wrapper">

    <!-- Page header -->
    @include('laravel_task_manager::layouts.clients.limitless_v16.helpers.helpers.page_container.helpers.main_content.page_header')
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        @yield(config('laravel_task_manager.task_master_yield_content'))

        <!-- Footer -->
        @include('laravel_task_manager::layouts.clients.limitless_v16.helpers.helpers.page_container.helpers.main_content.page_footer')
        <!-- /footer -->

    </div>
    <!-- /content area -->

</div>