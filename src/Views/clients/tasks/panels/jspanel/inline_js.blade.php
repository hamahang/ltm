<script>
    function addScript(path, type, callback) {
        let script = document.createElement('script');
        script.src = path;
        script.type = type;
        document.head.appendChild(script);
        window.upload_image = new Vue({
            el: '#upload_image_{{$variable}}',
        });
    }

    let route_name = '{{ route('ltm.clients.tasks.panels.get_datatable') }}';
    let variable = '{{$variable}}';
    window['columns'] = [
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
            'visible': false
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
            'width': '150px',
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

    $(document).off('click', "#btn_insert_task_{{$variable}}");
    $(document).on('click', "#btn_insert_task_{{$variable}}", function () {
        $("#submit_insert_task_{{$variable}}").click();
    });

    $(document).off('click', "#btn_insert_track_task_{{$variable}}");
    $(document).on('click', "#btn_insert_track_task_{{$variable}}", function () {
        $("#submit_insert_track_task_{{$variable}}").click();
    });

    $(document).ready(function () {
        window['{{$variable}}'].maximize();
        reloadData()

        let path = "{{asset('vendor/laravel_task_manager/build/upload_image.min.js')}}";
        let scriptType = 'text/javascript';
        addScript(path, scriptType)
    })

    let reloadData = () => {
        let data = {};
        dataTablesGrid('#TasksGridData', 'TasksGridData', route_name, columns, data, null, true, null, null, 1, 'desc');
    }

    $(document).off('click', '#btn_close_task_{{$variable}}')
    $(document).on('click', '#btn_close_task_{{$variable}}', function () {
        window[variable].close();
    })
</script>

<!--add scripts -->
<script>
    $(document).ready(function () {
        var form = document.querySelector('#form_task_add_{{$variable}}');
        var is_apply = false;
        var constraints =
            {
                general_importance:
                    {
                        presence: {message: '^<strong>اهمیت الزامی است</strong>'}
                    },
                general_immediate:
                    {
                        presence: {message: '^<strong>فوریت الزامی است</strong>'}
                    },
                general_title:
                    {
                        presence: {message: '^<strong>عنوان الزامی است</strong>'}
                    },
                general_subject_id:
                    {
                        presence: {message: '^<strong>موضوع الزامی است</strong>'}
                    },
                @if($user_requestes)
                file_no: {
                    presence: {message: '^<strong>شماره پرونده الزامی است</strong>'}
                },
                @endif
                        @if(is_array($step) || !$step)
                step_id: {
                    presence: {message: '^<strong>شماره گام الزامی است</strong>'}
                },
                @endif
            };

        function task_add(formElement) {
            var formData = new FormData(formElement);
            $.ajax
            ({
                type: 'post',
                url: '{{ route('ltm.clients.tasks.panels.add')}}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    $('#form_task_add_{{$variable}} .total_loader').remove();
                    if (result.success) {
                        setTimeout(function () {
                            $('a[href="#task_manage"]').tab('show').click()
                            TasksGridData.ajax.reload(null, false);
                        }, 100)


                        @if(!$request_id)
                        $('#general_file_no').val('').trigger('change');
                        $('#general_step_id').val('').trigger('change');
                        @endif
                        $('#general_keywords').val('').trigger('change');
                        $('#general_subject_id').val('').trigger('change');
                        $('#general_title').val('');
                        $('#general_description').val('');
                        $('#result').html('');
                        upload_image.$refs.uploadImage.resetForm()

                    } else {
                        showMessages(result.message, 'form_message_box_{{$variable}}', 'error', formElement);
                        showErrors(form, result.errors);
                    }
                }
            }).fail(function (result) {
                alert('خطای ' + result.statusText);
                $('.total_loader').remove();
            });
        }

        init_validatejs(form, constraints, task_add, '#form_task_add_{{$variable}}', true);
        //
        $(document).ready(function () {
            // inits
            init_select2_data('#general_subject_id', {!! $subjects !!}, false, true, false, false, 'انتخاب عنوان');

            init_select2_ajax('.general_keywords', '{{ route('ltm.auto_complete.keywords') }}', true, true, true);
            init_select2_ajax('.setting_action_do_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
            init_select2_ajax('.setting_action_transfer_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
            init_select2_ajax('.setting_action_reject_form_id', '{{ route('ltm.auto_complete.forms') }}', true);

            $(document).off('click', '.setting_email, .setting_sms, .setting_messaging').on('click', '.setting_email, .setting_sms, .setting_messaging', function () {
                $('.fg_' + $(this).attr('class')).toggle();
            });
        });
    });

    //---------------------------------------select 2------------//

    @if (!$request_id)
    var all_req_data = {!! json_encode($user_requestes) !!};
    @if ($step && isset($request_id) && $request_id && isset($user_requestes) && $user_requestes)
    var all_form_request_data = {!! json_encode(collect($user_requestes)->first(function ($value,$key) use($request_id){
                return $value->id == $request_id ;
            })->forms) !!};
    @else
    var all_form_request_data = {};
    @endif
    init_select2_data("#general_file_no", all_req_data, false, true, false, false, 'انتخاب شماره پرونده');
    init_select2_data("#general_step_id", all_form_request_data, false, true, false, false, 'ابتدا شماره پرونده را انتخاب کنید...');

    $('#general_file_no').on("select2:select", function (e) {
        var selected_data = e.params.data;
        selected_data.forms = selected_data.forms || {};
        $("#general_step_id").html('<option></option>');
        if (selected_data.forms.length > 0) {
            $("#general_step_id").select2("destroy");
            $("#general_step_id").html('');
            $("#general_step_id").html('<option></option>');
            init_select2_data("#general_step_id", selected_data.forms, false, true, false, false, 'انتخاب گام');
        } else {
            $("#general_step_id").select2("destroy");
            $("#general_step_id").html('');
            $("#general_step_id").html('<option></option>');
            init_select2_data("#general_step_id", {}, false, false, false, false, 'ابتدا شماره پرونده را انتخاب کنید...');
        }
    });

    @endif

    //---------------------------------------------------------//

    function hide_text_over_flow(el) {
        $(el).toggleClass('text_over_flow');
    }

    String.prototype.nums_to_en = function () {
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var r = this.toString();
        for (i = 0; i < 10; i++) {
            r = r.replace(fa[i], en[i]);
        }
        return r;
    };
    String.prototype.nums_to_fa = function () {
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        var r = this.toString();
        for (i = 0; i < 10; i++) {
            r = r.replace(en[i], fa[i]);
        }
        return r;
    };

    $(document).off('click', '.tabs_li');
    $(document).on('click', '.tabs_li', function () {
        var target = $(this).data('target');
        if (target == 'task_add') {
            $('#btn_insert_task_{{$variable}}').removeClass('hidden');
        } else {
            $('#btn_insert_task_{{$variable}}').addClass('hidden');
        }
        if (target == 'task_tracing') {
            $('#btn_insert_track_task_{{$variable}}').removeClass('hidden');
        } else {
            $('#btn_insert_track_task_{{$variable}}').addClass('hidden');
        }
        if (target == 'task_manage') {
            $('#btn_insert_task_{{$variable}}').addClass('hidden');
            $('#btn_insert_track_task_{{$variable}}').addClass('hidden');
        }
    });

    $(document).off('click', '.tracking_btn');
    $(document).on('click', '.tracking_btn', function () {
        var item_id = $(this).data('item_id');
        $('#btn_insert_task_{{$variable}}').addClass('hidden');
        get_tracking_view(item_id);
    });

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
                    $('a[href="#task_tracing"]').tab('show');
                    $('a[href="#task_tracing"]').click();
                    $('#btn_insert_track_task_{{$variable}}').removeClass('hidden');
                } else {

                }
            }
        }).fail(function (result) {
            alert('خطای ' + result.statusText);
            $('.total_loader').remove();
        });
    }


</script>

