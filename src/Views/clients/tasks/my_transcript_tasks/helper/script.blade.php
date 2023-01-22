<script>
    var my_transcript_tasks_route = '{{ route('ltm.clients.tasks.my_transcript_tasks.datatable_get') }}';
    window.my_transcript_tasks_grid_columns =
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
            'data': 'subject',
            'name': 'subject.title'
        },
        {
            'title': 'عنوان',
            'data': 'title',
            'name': 'title',
            render: function(data, type, row)
            {
                var title = row.title ? '<div class="text_over_flow">' + row.title + '</div>' : '[بدون عنوان]';
                if (row.visited)
                {
                    return title;
                } else
                {
                    return '<strong>' + title + '</strong>';
                }
            }
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'ارجاع دهنده',
            'data': 'assigner',
            'name': 'assigner'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'مسئول',
            'data': 'employee',
            'name': 'employee'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'وضعیت',
            'data': 'status',
            'name': 'status'
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'اهمیت',
            'data': 'importance',
            'name': 'importance',
            render: function (data, type, row)
            {
                return {0: 'غیر مهم', 1: 'مهم'}[row.importance];
            }
        },
        {
            'searchable': false,
            'sortable': false,
            'title': 'فوریت',
            'data': 'immediate',
            'name': 'immediate',
            render: function (data, type, row)
            {
                return {0: 'غیر فوری', 1: 'فوری'}[row.immediate];
            }
        },
        {
            'title': 'توضیحات',
            'visible': false,
            'data': 'task.description',
            'name': 'task.description'
        }
    ];
    function datatable_load(filter_code, filter_subject, filter_title, filter_assigner, filter_status, filter_importance, filter_immediate, filter_employee)
    {
        filter_code = filter_code || '';
        filter_subject = filter_subject || '';
        filter_title = filter_title || '';
        filter_assigner = filter_assigner || -1;
        filter_employee = filter_employee || -1;
        filter_status = filter_status || -1;
        filter_importance = filter_importance || -1;
        filter_immediate = filter_immediate || -1;
        data =
        {
            filter_code: filter_code,
            filter_subject: filter_subject,
            filter_title: filter_title,
            filter_assigner: filter_assigner,
            filter_employee: filter_employee,
            filter_status: filter_status,
            filter_importance: filter_importance,
            filter_immediate: filter_immediate
        };
        dataTablesGrid('.my_transcript_tasks', 'my_transcript_tasks', my_transcript_tasks_route, my_transcript_tasks_grid_columns, data, null, true, null, null, 1, null, true);
        $('.my_transcript_tasks thead').append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_code" style="" value="' + filter_code + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_subject" style="" value="' + filter_subject + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_title" style="" value="' + filter_title + '">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_assigner" style="min-width: 175px;">' +
            '           <option value="-1">همه</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_employee" style="min-width: 175px;">' +
            '           <option value="-1">همه</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_status" style="width: 100px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_status ? 'selected="selected"' : '') + '>آغاز نشده</option>' +
            '           <option value="1"' + ('1' === filter_status ? 'selected="selected"' : '') + '>در حال انجام</option>' +
            '           <option value="2"' + ('2' === filter_status ? 'selected="selected"' : '') + '>انجام شده</option>' +
            '           <option value="3"' + ('3' === filter_status ? 'selected="selected"' : '') + '>تائید شده</option>' +
            '           <option value="4"' + ('4' === filter_status ? 'selected="selected"' : '') + '>خاتمه یافته</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_importance" style="width: 85px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_importance ? 'selected="selected"' : '') + '>غیر مهم</option>' +
            '           <option value="1"' + ('1' === filter_importance ? 'selected="selected"' : '') + '>مهم</option>' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_immediate" style="width: 85px;">' +
            '           <option value="-1">همه</option>' +
            '           <option value="0"' + ('0' === filter_immediate ? 'selected="selected"' : '') + '>غیر فوری</option>' +
            '           <option value="1"' + ('1' === filter_immediate ? 'selected="selected"' : '') + '>فوری</option>' +
            '       </select>' +
            '   </td>' +
            '</tr>'
        );
        $('.filter_assigner').select2({ data: {!! $assigners !!} }).val(filter_assigner);
        $('.filter_employee').select2({ data: {!! $employees !!} }).val(filter_employee);
        //$('.my_transcript_tasks_tab').click();
    }
    function datatable_reload()
    {
        var filter_code = $('.filter_code').val();
        var filter_subject = $('.filter_subject').val();
        var filter_title = $('.filter_title').val();
        var filter_assigner = $('.filter_assigner').val();
        var filter_employee = $('.filter_employee').val();
        var filter_status = $('.filter_status').val();
        var filter_importance = $('.filter_importance').val();
        var filter_immediate = $('.filter_immediate').val();
        my_transcript_tasks.destroy();
        $('.my_transcript_tasks').empty();
        datatable_load(filter_code, filter_subject, filter_title, filter_assigner, filter_status, filter_importance, filter_immediate, filter_employee);
    }
    $(document).off('change', '.filter_assigner, .filter_employee, .filter_status, .filter_importance, .filter_immediate');
    $(document).on('change', '.filter_assigner, .filter_employee, .filter_status, .filter_importance, .filter_immediate', datatable_reload);
    init_doAfterStopTyping('.filter_code, .filter_subject, .filter_title', datatable_reload);
</script>
