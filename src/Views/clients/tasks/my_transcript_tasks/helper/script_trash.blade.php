<script>
    var my_transcript_tasks_trash_route = '{{ route('ltm.clients.tasks.my_transcript_tasks_trash.datatable_get_trash') }}';
    window.my_transcript_tasks_trash_grid_columns =
    [
        {
            'title': 'ردیف',
            'data': 'id',
            'searchable': true,
            'sortable': true,
            render: function (data, type, row, meta)
            {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            'title': 'شناسه',
            'data': 'task.code',
            'name': 'task.code'
        },
        {
            'title': 'موضوع',
            'data': 'subject_trash',
            'name': 'subject_trash.title'
        },
        {
            'title': 'عنوان',
            'data': 'title_trash',
            'name': 'title_trash',
            render: function(data, type, row)
            {
                var title_trash = row.title_trash ? '<div class="text_over_flow">' + row.title_trash + '</div>' : '[بدون عنوان]';
                if (row.visited_trash)
                {
                    return title_trash;
                } else
                {
                    return '<strong>' + title_trash + '</strong>';
                }
            }
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'ارجاع دهنده',
            'data': 'assigner_trash',
            'name': 'assigner_trash'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'مسئول',
            'data': 'employee_trash',
            'name': 'employee_trash'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'وضعیت',
            'data': 'status_trash',
            'name': 'status_trash'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'اهمیت',
            'data': 'importance_trash',
            'name': 'importance_trash',
            render: function (data, type, row)
            {
                return {0: 'غیر مهم', 1: 'مهم'}[row.importance_trash];
            }
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'فوریت',
            'data': 'immediate_trash',
            'name': 'immediate_trash',
            render: function (data, type, row)
            {
                return {0: 'غیر فوری', 1: 'فوری'}[row.immediate_trash];
            }
        },
        {
            'title': 'توضیحات',
            'visible': false,
            'data': 'task.description',
            'name': 'task.description'
        }
    ];
    function datatable_load_trash(filter_code_trash, filter_subject_trash, filter_title_trash, filter_assigner_trash, filter_status_trash, filter_importance_trash, filter_immediate_trash, filter_employee_trash)
    {
        filter_code_trash = filter_code_trash || '';
        filter_subject_trash = filter_subject_trash || '';
        filter_title_trash = filter_title_trash || '';
        filter_assigner_trash = filter_assigner_trash || -1;
        filter_employee_trash = filter_employee_trash || -1;
        filter_status_trash = filter_status_trash || -1;
        filter_importance_trash = filter_importance_trash || -1;
        filter_immediate_trash = filter_immediate_trash || -1;
        data_trash =
        {
            filter_code_trash: filter_code_trash,
            filter_subject_trash: filter_subject_trash,
            filter_title_trash: filter_title_trash,
            filter_assigner_trash: filter_assigner_trash,
            filter_employee_trash: filter_employee_trash,
            filter_status_trash: filter_status_trash,
            filter_importance_trash: filter_importance_trash,
            filter_immediate_trash: filter_immediate_trash
        };
        dataTablesGrid('.my_transcript_tasks_trash', 'my_transcript_tasks_trash', my_transcript_tasks_trash_route, my_transcript_tasks_trash_grid_columns, data_trash, null, true, null, null, 1, null, true);
        $('.my_transcript_tasks_trash thead').append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_code_trash" style="" value="' + filter_code_trash + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_subject_trash" style="" value="' + filter_subject_trash + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_title_trash" style="" value="' + filter_title_trash + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_assigner_trash" style="min-width: 175px;">' +
            '           <option value="-1">همه</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_employee_trash" style="min-width: 175px;">' +
            '           <option value="-1">همه</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_status_trash" style="width: 100px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_status_trash ? 'selected="selected"' : '') + '>آغاز نشده</option>' +
            '           <option value="1"' + ('1' === filter_status_trash ? 'selected="selected"' : '') + '>در حال انجام</option>' +
            '           <option value="2"' + ('2' === filter_status_trash ? 'selected="selected"' : '') + '>انجام شده</option>' +
            '           <option value="3"' + ('3' === filter_status_trash ? 'selected="selected"' : '') + '>تائید شده</option>' +
            '           <option value="4"' + ('4' === filter_status_trash ? 'selected="selected"' : '') + '>خاتمه یافته</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_importance_trash" style="width: 85px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_importance_trash ? 'selected="selected"' : '') + '>غیر مهم</option>' +
            '           <option value="1"' + ('1' === filter_importance_trash ? 'selected="selected"' : '') + '>مهم</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_immediate_trash" style="width: 85px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_immediate_trash ? 'selected="selected"' : '') + '>غیر فوری</option>' +
            '           <option value="1"' + ('1' === filter_immediate_trash ? 'selected="selected"' : '') + '>فوری</option>' +
            '       </select>' +
            '   </td>' +
            '</tr>'
        );
        $('.filter_assigner_trash').select2({ data: {!! $assigners_trash !!} }).val(filter_assigner_trash);
        $('.filter_employee_trash').select2({ data: {!! $employees_trash !!} }).val(filter_employee_trash);
        //  $('.my_transcript_tasks_trash_tab').click();
    }
    function datatable_reload_trash()
    {
        var filter_code_trash = $('.filter_code_trash').val();
        var filter_subject_trash = $('.filter_subject_trash').val();
        var filter_title_trash = $('.filter_title_trash').val();
        var filter_assigner_trash = $('.filter_assigner_trash').val();
        var filter_employee_trash = $('.filter_employee_trash').val();
        var filter_status_trash = $('.filter_status_trash').val();
        var filter_importance_trash = $('.filter_importance_trash').val();
        var filter_immediate_trash = $('.filter_immediate_trash').val();
        my_transcript_tasks_trash.destroy();
        $('.my_transcript_tasks_trash').empty();
        datatable_load_trash(filter_code_trash, filter_subject_trash, filter_title_trash, filter_assigner_trash, filter_status_trash, filter_importance_trash, filter_immediate_trash, filter_employee_trash);
    }
    $(document).off('change', '.filter_assigner_trash, .filter_employee_trash, .filter_status_trash, .filter_importance_trash, .filter_immediate_trash');
    $(document).on('change', '.filter_assigner_trash, .filter_employee_trash, .filter_status_trash, .filter_importance_trash, .filter_immediate_trash', datatable_reload_trash);
    init_doAfterStopTyping('.filter_code_trash, .filter_subject_trash, .filter_title_trash', datatable_reload_trash);
</script>
