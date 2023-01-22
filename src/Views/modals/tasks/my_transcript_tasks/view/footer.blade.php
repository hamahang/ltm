@php
    $types =
    [
        '<span style="color: green; font-weight: bold;">رویداد</span>&emsp;<span style="color: lightgray;">فعالیت</span>',
        '<span style="color: lightgray;">رویداد</span>&emsp;<span style="color: green; font-weight: bold;">فعالیت</span>',
    ];
    $importances =
    [
        '<span style="color: green; font-weight: bold;">غیر مهم</span>&emsp;<span style="color: lightgray;">مهم</span>',
        '<span style="color: lightgray;">غیر مهم</span>&emsp;<span style="color: red; font-weight: bold;">مهم</span>',
    ];
    $immediates =
    [
        '<span style="color: green; font-weight: bold;">غیر فوری</span>&emsp;<span style="color: lightgray;">فوری</span>',
        '<span style="color: lightgray;">غیر فوری</span>&emsp;<span style="color: red; font-weight: bold;">فوری</span>',
    ];
@endphp

<div class="pull-left col-md-11">
    {!! $progress['assigner']->avatar32 !!}&emsp;&emsp;&emsp;
    {!! $progress['employee']->avatar32 !!}&emsp;&emsp;&emsp;
    {!! $types[$task->type] !!}&emsp;&emsp;&emsp;
    {!! $importances[$task->assigner_priority->importance] !!}&emsp;&emsp;&emsp;
    {!! $immediates[$task->assigner_priority->immediate] !!}&emsp;&emsp;&emsp;
    مهلت انجام باقیمانده&nbsp;{!! $task->human_remaining_duration_timestamp !!}&emsp;&emsp;&emsp;
</div>

<button class="btn btn_close">بستن</button>

@include('laravel_task_manager::modals.tasks.my_transcript_tasks.view.helpers.style')
@include('laravel_task_manager::modals.tasks.my_transcript_tasks.view.helpers.script')
