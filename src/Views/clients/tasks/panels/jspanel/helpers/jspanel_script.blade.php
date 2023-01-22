<script type="text/javascript">
    window.TasksGridData = "";
    window['my_assigned_tasks_grid_columns'] =
        [
            {
                'title': 'ردیف',
                'data': 'id',
                'searchable': true,
                'sortable': true,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                'title': 'آی دی',
                'data': 'id',
                'name': 'id',
                'visible':false
            },
            @if($user_requestes)
            {
                'title': 'شماره پرونده',
                'data': 'file_no',
                'name': 'task.file_no'
            },
            @endif
            @if(is_array($step) || !$step)
            {
                'title': 'گام',
                'data': 'step_name',
                'name': 'task.step_id'
            },
            @endif
            {
                'width' : '150px',
                'title': 'موضوع',
                'data': 'subject',
                'name': 'task.subject.title'
            },
            {
                'title': 'عنوان',
                'data': 'title',
                'name': 'task.title',
                render: function (data, type, row) {
                    var title = row.title ? '<div class="text_over_flow">' + row.title + '</div>' : '[بدون عنوان]';
                    if (row.visited) {
                        return title;
                    } else {
                        return '<strong>' + title + '</strong>';
                    }
                }
            },
            // {
            //     'searchable': false,
            //     'title': 'مسئول',
            //     'data': 'employee',
            //     'name': 'employee'
            // },
            // {
            //     'searchable': false,
            //     'sortable': false,
            //     'title': 'وضعیت',
            //     'data': 'status',
            //     'name': 'status'
            // },
            {
                'searchable': false,
                'sortable': false,
                'title': 'اهمیت',
                'data': 'importance',
                'name': 'importance',
                render: function (data, type, row) {
                    return {0: 'غیر مهم', 1: 'مهم'}[row.importance];
                }
            },
            {
                'searchable': false,
                'sortable': false,
                'title': 'فوریت',
                'data': 'immediate',
                'name': 'immediate',
                render: function (data, type, row) {
                    return {0: 'غیر فوری', 1: 'فوری'}[row.immediate];
                }
            },
            {
                'title': 'توضیحات',
                'visible': false,
                'data': 'description',
                'name': 'task.description'
            },
            {
                width: '10%',
                searchable: false,
                sortable: false,
                data: 'action', name: 'action', 'title': 'عملیات',
                mRender: function (data, type, full) {
                    return '<button class="btn btn-xs btn-info tracking_btn" data-item_id="' + full.id + '"> پیگیری </button>';
                }
            }
        ];
    $(document).ready(function () {
        datatable_load_fun() ;
        var variable = "{{$variable}}";
        window[variable].maximize();
    });

    $(document).off('click', '.tracking_btn');
    $(document).on('click', '.tracking_btn', function () {
        var item_id = $(this).data('item_id');
        $('#btn_insert_task_{{$variable}}').addClass('hidden');
        get_tracking_view(item_id);
    });
    
    function datatable_load_fun() {
        var my_assigned_tasks_route = '{{ route('ltm.clients.tasks.panels.get_datatable') }}';
        fixedColumn = {
            leftColumns: 3,
            rightColumns: 1
        };
        var filter_file_no = $('#filter_file_no').val();
        var filter_step_id = $('#filter_step_id').val();
        data ={
            filter_file_no:filter_file_no,
            filter_step_id:filter_step_id,
        };
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "scripts/server_processing.php"
        } );
        // $('#TasksGridData').DataTable( {
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url: my_assigned_tasks_route,
        //         type: 'POST',
        //         data: data,
        //         columns: columns,
        //     },
        // } );
        var CommonDom_DataTables = '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>';
        dataTablesGrid('#TasksGridData', 'TasksGridData', my_assigned_tasks_route, my_assigned_tasks_grid_columns, data, null, true, null, null, 1, 'desc', false, fixedColumn);
        // $('.dataTables_processing').css({"border-radius": "none", "z-index": 100000,"background":"#00000087","font-weight":"bolder","color":"#ffffff" })
    }
    function get_tracking_view(item_id) {
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.clients.tasks.panels.get_tracking_view')}}',
            dataType: "json",
            data: {
                item_id: item_id,
                request_id: '{{$request_id}}',
                variable: '{{$variable}}',
            },
            success: function (data) {
                if (data.success) {
                    $('#task_tracing').html(data.view);
                    $('#li_task_tracking').removeClass('hidden');
                    $('a[href="#task_tracing"]').click();
                    $('#btn_insert_track_task_{{$variable}}').removeClass('hidden');
                }
                else {

                }
            }
        }).fail(function (result) {
            alert('خطای ' + result.statusText);
            $('.total_loader').remove();
        });
    }

    $(document).off('click', '.tabs_li');
    $(document).on('click', '.tabs_li', function () {
        var target = $(this).data('target');
        if (target == 'task_add') {
            $('#btn_insert_task_{{$variable}}').removeClass('hidden');
        }
        else {
            $('#btn_insert_task_{{$variable}}').addClass('hidden');
        }
        if (target == 'task_tracing') {
            $('#btn_insert_track_task_{{$variable}}').removeClass('hidden');
        }
        else {
            $('#btn_insert_track_task_{{$variable}}').addClass('hidden');
        }
        if (target == 'task_manage') {
            $('#btn_insert_task_{{$variable}}').addClass('hidden');
            $('#btn_insert_track_task_{{$variable}}').addClass('hidden');
        }
    });

    $(document).off('click', '.cancel_track_request');
    $(document).on('click', '.cancel_track_request', function (e) {
        $('#li_task_tracking').addClass('hidden');
        setTimeout(function() {
            $('a[href="#task_manage"]').click();
        }, 100);
    });

</script>