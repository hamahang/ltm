<div style="margin-top: 15px;">
    <div class="radio-inline"><label for="new_task_save_type_draft"><input type="radio" class="new_task_save_type_draft" id="new_task_save_type_draft" name="new_task_save_type" value="0" disabled="disabled" />پیش نویس</label></div>
    <div class="radio-inline"><label for="new_task_save_type_final"><input type="radio" class="new_task_save_type_final" id="new_task_save_type_final" name="new_task_save_type" value="1" checked />نهایی</label></div>
</div>
<a type="button" class="btn btn-primary pull-left bnt_save" data-apply="true">تایید</a>
<a type="button" class="btn btn-primary pull-left bnt_save">تایید و افزودن وظیفه جدید</a>
<button class="btn btn-primary btn_close hidden">بستن</button>

@include('laravel_task_manager::modals.tasks.task.add.helpers.style')
@include('laravel_task_manager::modals.tasks.task.add.helpers.script')
