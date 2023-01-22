<style>
    .datatable_custom_proccessing{
        background-color: red;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-body">
        <div class="tabbable">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="tabs_li active" data-target="task_manage"><a href="#task_manage" data-toggle="tab">لیست درخواست های پشتیبانی</a></li>
                <li class="tabs_li"  data-target="task_add"><a href="#task_add" data-toggle="tab">ایجاد درخواست پشتیبانی جدید</a></li>
                <li class="tabs_li hidden" id="li_task_tracking" style="position: relative"  data-target="task_tracing">
                    <button class="close closeTab cancel_track_request" type="button" style="position: absolute;left: 7px;top: 0px;z-index: 50;">×</button>
                    <a href="#task_tracing" data-toggle="tab" style="padding-left: 25px;">پیگیری</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="task_manage" style="position: relative;">
                    @include('laravel_task_manager::clients.tasks.panels.jspanel.view.filter')
                    <div class="col-xs-12">
                        <table id="TasksGridData" class="table " width="100%"></table>
                    </div>
                </div>
                <div class="tab-pane" id="task_add">
                    <div class="space-10"></div>
                    @include('laravel_task_manager::clients.tasks.panels.jspanel.view.add_task')
                </div>
                <div class="tab-pane" id="task_tracing"></div>
            </div>
        </div>
    </div>
</div>
@include('laravel_task_manager::clients.tasks.panels.jspanel.helpers.jspanel_script')
