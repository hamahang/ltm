@extends(config('laravel_task_manager.task_master'))
@section(config('laravel_task_manager.task_master_yield_page_title'), 'پیشخوان')
@section(config('laravel_task_manager.task_master_yield_content'))
    <div class="row">
        <div class="well col-md-3">
            شما <a href="{!! url(route('ltm.clients.tasks.my_tasks.index')) !!}">{!! $counters['my_tasks'] !!} وظیفه ({!! $counters['my_tasks_new'] !!} جدید) دارید.</a>
        </div>
        <div class="well col-md-3 col-md-offset-1">
            شما <a href="{!! url(route('ltm.clients.tasks.my_assigned_tasks.index')) !!}">{!! $counters['my_assigned_tasks'] !!} وظیفه </a>ارجاع داده اید.
        </div>
        <div class="well col-md-3 col-md-offset-1">
            شما <a href="{!! url(route('ltm.clients.tasks.my_transcript_tasks.index')) !!}">{!! $counters['my_transcript_tasks'] !!} رونوشت </a>دارید.
        </div>
    </div>
@stop

