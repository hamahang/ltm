<style>
    .form-inline {
        display: block;
    }
    .by0 select.form-control {
        border-radius: 4px;
    }
    .by0 textarea.form-control {
        border-radius: 4px ;
    }
    .by0 input.form-control {
        border-radius: 4px;
    }
    .by0 span.select2-selection.select2-selection--single {
        border-radius: 4px;
    }
    .hidden{
        display: none;
    }
</style>
<div class="card jspanelTicket">
    <div class="card-header">
        <span>درخواست های پشتیبانی</span>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item tabs_li" id="li_task_manage" data-target="task_manage">
                <a class="nav-link active" id="task_manage-tab" data-toggle="tab" href="#task_manage" role="tab" aria-controls="task_manage" aria-selected="true">
                    <i class="fa fa-list-alt"></i>
                    <span>لیست درخواست ها</span>
                </a>
            </li>
            <li class="nav-item tabs_li" data-target="task_add">
                <a class="nav-link" id="task_add-tab" data-toggle="tab" href="#task_add" role="tab" aria-controls="task_add" aria-selected="false">
                    <i class="fa fa-plus"></i>
                    <span>افزودن</span>
                </a>
            </li>
            <li class="nav-item tabs_li hidden" data-target="task_tracing" id="li_task_tracking">
                <a class="nav-link" id="task_tracing-tab"  data-toggle="tab" href="#task_tracing" role="tab" aria-controls="task_tracing" aria-selected="false">
                    <i class="fa fa-edit"></i>
                    <span>ویرایش</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="task_manage" role="tabpanel" aria-labelledby="task_manage-tab">
                <div class="card">
                    <div class="card-body">
                        <table id="TasksGridData" class="table" width="100%"></table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="task_add" role="tabpanel" aria-labelledby="task_add-tab">
                <div class="card">
                    <div class="card-body">
                        @include('laravel_task_manager::clients.tasks.panels.jspanel.view.add_task')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="task_tracing" role="tabpanel" aria-labelledby="task_tracing-tab">

            </div>
        </div>
    </div>
</div>