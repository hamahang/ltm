<script>
    $('.filter').select2({
        allowClear: true,
        dir: "rtl",
        width: "100%",
        placeholder: 'جستجو کنید ...',
        language: "fa"
    });

    var stack_top_left = {"dir1": "down", "dir2": "left", "push": "top"};

    function print_ajax_error(text) {
        // Solid danger
        new PNotify({
            title: 'خطا',
            text: text,
            addclass: 'bg-danger stack-top-left',
            stack: stack_top_left
        });
    }

    function print_ajax_success_msg(text) {

        // Solid success
        new PNotify({
            title: 'تایید',
            text: text,
            addclass: 'bg-success stack-top-left',
            stack: stack_top_left
        });
    }

    var Grid_Table = "";

    function GoToManageTab() {
        $('a[href="#manage_tab"]').click();
    }

    function set_data_item_edit_form(item_id) {
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.backend.subjects.getSubject')}}',
            dataType: "json",
            data: {id: item_id},
            success: function (data) {
                $('#title_item_id').val(item_id);
                $('#edit_form_input_code').html(data['info'].code);
                $('#edit_form_input_title').val(data['info'].title);
                $('#edit_form_input_background_color').val(data['info'].background_color);
                $('#edit_form_input_text_color').val(data['info'].text_color);
                $('#edit_form_input_title_list').val(data['info'].parent_id).trigger("change");
            }
        });
    }

    function store_add_form_data(step_id) {
        var form_data = $('#' + step_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.backend.subjects.store')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    print_ajax_success_msg(result.message);
                    document.getElementById(step_id).reset();
                    $('a[href="#manage_tab"]').click();
                    reload_Grid_Table();
                }
                else {
                    $.each(result.error,function (index,value) {
                        print_ajax_error(value);
                    });

                }
            }
        });
    }

    function edit_grid_item(item_id) {
        set_data_item_edit_form(item_id);
        var li_tab = '<li class=""><a href="#edit_tab" data-toggle="tab" class="legitRipple edit_cat_tab" aria-expanded="false"><span class="fa fa-edit"></span> {{trans('ltm_app.edit_tab')}}</a></li>';
        $('.edit_cat_tab').remove();
        $('#manage').append(li_tab);
        $('#manage a[href="#edit_tab"]').tab('show');
    }

    function update_edit_form_data(step_id) {
        var form_data = $('#' + step_id).serialize();
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.backend.subjects.update')}}',
            dataType: "json",
            data: form_data,
            success: function (result) {
                if (result.success == true) {
                    print_ajax_success_msg(result.message);
                    document.getElementById(step_id).reset();
                    $('a[href="#manage_tab"]').click();
                    $('.edit_cat_tab').remove();
                    reload_Grid_Table();
                }
                else {
                    print_ajax_error(result.error)
                }
            }
        });
    }

    function destroy_item(item_id, item_name) {
        $.confirm({
            title: '{{ trans('ltm_app.are_you_sure_to_delete') }}',
            content: item_name,
            buttons: {
                cancel: {
                    text: '{{ trans('ltm_app.no')}}',

                },
                confirm: {
                    text: '{{ trans('ltm_app.yes')}}',
                    btnClass: 'btn-red',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('ltm.backend.subjects.destroy')}}',
                            dataType: "json",
                            data: {
                                item_id: item_id
                            },
                            success: function (result) {
                                $('#delete-modal').modal('hide');

                                if (result.success == true) {
                                    print_ajax_success_msg(result.message);
                                    $('a[href="#manage_tab"]').click();
                                    reload_Grid_Table();
                                }
                                else {
                                    print_ajax_error(result.error)
                                }
                            }
                        });
                    }
                }

            }
        });
    }

    function Data_Tables_Grid(target_id) {

        Grid_Table = $('#' + target_id).DataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "language": window.LangJson_DataTables,
            "order": [[1, "asc"]],
            ajax: {
                url: '{!! route('ltm.backend.subjects.getSubjects') !!}',
                type: 'POST'
            },
            columns: [
                {
                    searchable: false,
                    sortable: false,
                    mRender: function (data, type, full) {
                        return '';
                    }
                },
                {
                    data: 'order', name: 'order',
                    mRender: function (data, type, full) {
                        return '' +
                            '<div class="grid_ordering_elements ordering_disabled">' +
                            '   <table border="0">' +
                            '       <tbody>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a id="ordering_asc">' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="up" data-one_order_step="asc" class="fa fa-2 fa-sort-asc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '               <td style="padding: 1px!important;vertical-align: middle" rowspan="2">' +
                            '                   <input id="ordering_input" style="width:30px; text-align: center;" type="text" name="item_order[\'' + full.id + '\']" value="' + full.order + '">' +
                            '                   <a class="save_btn" data-item_id="' + full.id + '" data-order_type="save" data-one_order_step="data">' +
                            '                       <i class="fa fa-save"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '           <tr>' +
                            '               <td style="padding: 1px!important">' +
                            '                   <a>' +
                            '                       <i data-item_id="' + full.id + '" data-order_type="down" data-one_order_step="desc" class="fa fa-2 fa-sort-desc" aria-hidden="true"></i>' +
                            '                   </a>' +
                            '               </td>' +
                            '           </tr>' +
                            '       </tbody>' +
                            '   </table>' +
                            '</div>';
                    }
                },
                {data: 'title'},
                {
                    data: 'parent', name: 'parent',
                    mRender: function (data, type, full) {
                        if (full.parent != null)
                            return '<a>' + full.parent.title + '</a>';
                        else
                            return '';
                    }
                },
                {
                    data: 'created_by',
                    mRender: function (data, type, full) {

                        if (full.user) {
                            if (full.user.first_name && full.user.last_name)
                                return '<span>' + full.user.first_name + ' ' + full.user.last_name + '<span>';
                        }
                        else
                            return '<span><span>';
                    }
                },
                {data: 'created_at'},
                {
                    data: 'action', name: 'action',
                    mRender: function (data, type, full) {
                        var result = '';
                        result += '<button type="button" class="btn btn-xs bg-danger-800 fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button> ';
                        result += '<button type="button" class="btn btn-xs bg-warning-400 fa fa-reply btn_grid_item_edit" data-grid_item_id="' + full.id + '"></button>';
                        result += '<button type="button" style="margin-right: 5px; margin-top: 3px;" data-href="{{route('ltm.backend.subjects.add_subject')}}/' + full.id + '" class="btn btn-xs bg-warning-400 icon-gear jsPanels" data-grid_item_id="' + full.id + '"></button>';
                        return result;
                    }
                }
            ]
        });
        window.Grid_Table.on('order.dt', function (e, details, edit) {
            if (window.Grid_Table.order()[0][0] == 1) {
                $('.grid_ordering_elements').removeClass('ordering_disabled');
            }
            else {
                $('.grid_ordering_elements').addClass('ordering_disabled');
            }
        });
        Grid_Table.on('order.dt search.dt', function () {
            Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }

    function change_order(id, type, value, order_step) {
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.backend.subjects.setOrder')}}',
            dataType: "json",
            data: {
                id: id,
                type: type,
                value: value,
                order_step: order_step
            },
            success: function (result) {
                if (result.success == true) {
                    print_ajax_success_msg(result.message);
                    reload_Grid_Table();
                }
                else {
                    print_ajax_error(result.error)
                }
            }
        });
    }

    function reload_Grid_Table() {
        GridData.ajax.reload();
    }

    $(document).on("click", ".btn_grid_item_edit", function () {
        var $this = $(this);
        var item_id = $this.data('grid_item_id');
        edit_grid_item(item_id);
    });

    $(document).on("click", ".btn_grid_destroy_item", function () {
        var $this = $(this);
        var item_id = $this.data('grid_item_id');
        var item_name = $this.data('grid_item_name');
        destroy_item(item_id, item_name);
    });

    $('.submit_form_btn').on('click', function () {
        var $this = $(this);
        var step_id = $this.data('step_id');
        if (step_id == 'form_edit_item') {
            update_edit_form_data(step_id);
        }
        if (step_id == 'form_created_new') {
            store_add_form_data(step_id);
        }
    });

    $('.cancel_form_btn').on('click', function () {
        var $this = $(this);
        var step_id = $this.data('step_id');
        if (step_id == 'form_edit_item') {
            document.getElementById(step_id).reset();
            $('.select').select2();
            GoToManageTab();
            $('.edit_cat_tab').remove();
            reload_Grid_Table();
        }
        if (step_id == 'form_created_new') {
            document.getElementById(step_id).reset();
            GoToManageTab();
            $('.select').select2();
            reload_Grid_Table();
        }
    });

    $(document).on("click", ".fa-sort-asc, .fa-sort-desc, .save_btn", function () {
        var $this = $(this);
        var id = $this.data('item_id');
        var type = $this.data('order_type');
        var order_step = Grid_Table.order()[0][1];
        var value = $('input[name="item_order[\'' + id + '\']"]').val();
        change_order(id, type, value, order_step);
    });

    //Data_Tables_Grid('GridData');
    window.GridData = "";

    $(function()
    {
        ajax_url = '{!! route('ltm.backend.subjects.getSubjects') !!}';
        columns =
        [
            {
                title: "ردیف",
                width: "10px",
                data: "id",
                searchable: false,
                render: function(data, type, row, meta)
                {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'code',
                name: 'code'
            },
            {
                data: 'title',
                name: 'title',
                render: function (data, type, full)
                {
                    return '<div style="background-color: ' + full.background_color + '; color: ' + full.text_color + '; padding: 5px 10px; width: 100%; margin: auto;">' + full.title + '</div>';
                }
            },
            {
                data: 'parent',
                name: 'parent',
                mRender: function (data, type, full)
                {
                    if (full.parent != null)
                    {
                        return '<a>' + full.parent.title + '</a>';
                    } else
                    {
                        return '';
                    }
                }
            },
            {
                data: 'created_by',
                mRender: function (data, type, full)
                {
                    if (full.user)
                    {
                        if (full.user.first_name && full.user.last_name)
                            return '<span>' + full.user.first_name + ' ' + full.user.last_name + '<span>';
                    } else
                    {
                        return '<span><span>';
                    }
                }
            },
            {
                data: 'created_at'
            },
            {
                title: "ترتیب",
                data: 'order',
                name: 'order',
                visible: false,
                mRender: function(data, type, full)
                {
                    var order = GridData.order();
                    //console.log(order);
                    if (order[0][0] == 10)
                    {
                        if (order[0][1] == 'desc')
                        {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="increase" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="decrease"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        } else
                        {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="decrease" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="increase"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        }
                    } else
                    {
                        return '<span class="order_number">' + full.order + '</span>';
                    }
                }
            },
            {
                data: 'action', name: 'action',
                mRender: function(data, type, full)
                {
                    var result = '';
                    result += '<button type="button" class="btn btn-xs bg-danger-800 fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full.id + '" data-grid_item_name="' + full.title + '"></button> ';
                    result += '<button type="button" class="btn btn-xs bg-warning-400 fa fa-reply btn_grid_item_edit" data-grid_item_id="' + full.id + '"></button>';
                    result += '<button type="button" style="margin-right: 5px; margin-top: 3px;" data-href="{{route('ltm.backend.subjects.add_subject')}}/' + full.id + '" class="btn btn-xs bg-warning-400 icon-gear jsPanels" data-title="تنظیمات موضوع" data-grid_item_id="' + full.id + '"></button>';
                    return result;
                }
            },
        ];
        dataTablesGrid('#GridData', 'GridData', ajax_url, columns, null, null, true,'35vh',true);
        /*$('.filter-select').select2();*/
    });

    $(document).off("click", '.btn_filter').on('click', '.btn_filter', function () {
        GridData.destroy();
        $('.GridData').empty();

        var filter = $('#filter').val();
        if (filter == null) {
            var f = window.columns;
            f[5] = {
                title: "ترتیب",
                data: 'order',
                name: 'order',
                visible: false,
                mRender: function (data, type, full) {
                    var order = GridData.order();
                    if (order[0][0] == 5) {
                        if (order[0][1] == 'desc') {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="increase" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="decrease"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        }
                        else {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="decrease" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="increase"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        }

                    }
                    else {
                        return '<span class="order_number">' + full.order + '</span>';
                    }
                }
            };
            dataTablesGrid('#GridData', 'GridData', ajax_url, f, null, true,'35vh',true);
        }
        else{
            //console.log('with_order');
            var x = window.columns;
            x[5] = {
                title: "ترتیب",
                data: 'order',
                name: 'order',
                visible: true,
                mRender: function (data, type, full) {
                    var order = GridData.order();
                    //console.log(order);

                    if (order[0][0] == 5) {
                        if (order[0][1] == 'desc') {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="increase" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="decrease"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        }
                        else {
                            var result = '';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-400 fa fa-level-up reorder_work_group_item" ' +
                                '      data-order_type="decrease" ' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            result += '<span class="order_number">' + full.order + '</span>';
                            result += '' +
                                '   <button type="button" class="btn btn-xs bg-info-800 fa fa-level-down reorder_work_group_item" ' +
                                '      data-order_type="increase"' +
                                '      data-parent_id="' + full.parent_id + '" ' +
                                '      data-id="' + full.id + '" >' +
                                '   </button>';
                            return result;
                        }

                    }
                    else {
                        return '<span class="order_number">' + full.order + '</span>';
                    }

                }
            };
            dataTablesGrid('#GridData', 'GridData', ajax_url, x, {subject_id: filter}, null, true,'35vh',true);
        }
    });

    function reOrderWorkGroupItem(id,parent_id, order_type) {
        var result = false;
        $.ajax({
            type: "POST",
            url: '{{ route('ltm.backend.subjects.save_order')}}',
            dataType: "json",
            data: {id:id,parent_id: parent_id, order_type: order_type},
            success: function (data) {
                if (data.success == true) {
                    window.GridData.ajax.reload();
                    result = true;
                }
            }
        });
        return result;
    }

    $(document).off("click", '.reorder_work_group_item').on('click', '.reorder_work_group_item', function () {
        var $this = $(this);
        var order_type = $this.data('order_type');
        var id = $this.data('id');
        var parent_id = $this.data('parent_id');
        reOrderWorkGroupItem(id,parent_id, order_type);
    });

    $('.select_row').select2({
        dir: "rtl",
        width: "100%",
        placeholder: 'جستجو کنید ...',
        language: "fa"
    });





    $(document).on('change', '.select_subject', function()
    {
        var subject_id = $(this).val();
        $.ajax
        ({
            type: 'POST',
            url: '{{ route('ltm.backend.subjects.test_get_data')}}',
            data: {subject_id: subject_id},
            dataType: 'json',
            success: function(data_res)
            {
                if ('1' == data_res.status)
                {
                    var option = '';
                    $.each(data_res.data, function(index, value)
                    {
                        option = option + '<option value="' + value.id + '">' + value.text + '</option>';
                    });
                    $('.select_row').html(option);
                } else
                {
                    $('.select_row').html('');
                    $('.panel_template').html('');
                    print_ajax_error(data_res.data)
                }
            }
        });
    });





    $(document).on('click', '.ladda_button', function()
    {
        var subject_id = $('.select_subject').val();
        var row_id = $('.select_row').val();
        $.ajax
        ({
            type: 'POST',
            url: '{{ route('ltm.backend.subjects.test_get_data')}}',
            data: {subject_id: subject_id, row_id: row_id},
            dataType: 'json',
            success: function (data_res)
            {
                if (data_res.status == '1')
                {
                    var panel = '';
                    $.each( data_res.data, function(index, value)
                    {
                        panel = panel + '<div class="row panel" >' + value + '</div>';
                    });
                    $('.panel_template').html(panel);
                } else
                {
                    $('.panel_template').html('');
                    print_ajax_error(data_res.data);
                }
            }
        });
    });





    var source =  {!! $json  !!};
    $("#tree").fancytree({
        ltr: true,
        source: source,
    });
</script>