<script>
    $(document).ready(function () {
        var form = document.querySelector('#form_task_add_{{$variable}}');
        var is_apply = false ;
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
        function task_add(formElement)
        {
            var formData = new FormData(formElement);
            $.ajax
            ({
                type: 'post',
                url: '{{ route('ltm.clients.tasks.panels.add')}}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result)
                {
                    $('#form_task_add_{{$variable}} .total_loader').remove();
                    if (result.success)
                    {
                        TasksGridData.ajax.reload(null, false);

                        @if(!$request_id)
                        $('#general_file_no').val('').trigger('change');
                        $('#general_step_id').val('').trigger('change');
                        @endif
                        $('#general_keywords').val('').trigger('change');
                        $('#general_subject_id').val('').trigger('change');
                        $('#general_title').val('');
                        $('#general_description').val('');
                        $('#result').html('');
                        $('a[href="#task_manage"]').click();
                    }
                    else
                    {
                        showMessages(result.message, 'form_message_box_{{$variable}}', 'error', formElement);
                        showErrors(form, result.errors);
                    }
                }
            }).fail(function(result)
            {
                alert('خطای ' + result.statusText);
                $('.total_loader').remove();
            });
        }
        init_validatejs(form, constraints, task_add, '#form_task_add_{{$variable}}',true);
        //
        $(document).ready(function()
        {
            // inits
            init_select2_ajax('.general_subject_id', '{{ route('ltm.auto_complete.subjects') }}', true);
            init_select2_ajax('.general_keywords', '{{ route('ltm.auto_complete.keywords') }}', true, true, true);
            init_select2_ajax('.setting_action_do_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
            init_select2_ajax('.setting_action_transfer_form_id', '{{ route('ltm.auto_complete.forms') }}', true);
            init_select2_ajax('.setting_action_reject_form_id', '{{ route('ltm.auto_complete.forms') }}', true);

            $(document).off('click', '.setting_email, .setting_sms, .setting_messaging').on('click', '.setting_email, .setting_sms, .setting_messaging', function()
            {
                $('.fg_' + $(this).attr('class')).toggle();
            });
        });
        {{--$(document).on('change', '.general_subject_id', function()--}}
        {{--{--}}
            {{--var subject_id = $(this).val();--}}
            {{--$.ajax--}}
            {{--({--}}
                {{--type: 'POST',--}}
                {{--url: '{{ route('ltm.backend.subjects.test_get_data') }}',--}}
                {{--data: {subject_id: subject_id},--}}
                {{--dataType: 'json',--}}
                {{--success: function(data_res)--}}
                {{--{--}}
                    {{--if ('1' == data_res.status)--}}
                    {{--{--}}
                        {{--var options = '<option value="">بدون شماره پرونده</option>';--}}
                        {{--$.each(data_res.data, function(index, value)--}}
                        {{--{--}}
                            {{--options = options + '<option value="' + value.id + '">' + value.text + '</option>';--}}
                        {{--});--}}
                        {{--$('.general_file_no').html(options);--}}
                    {{--} else--}}
                    {{--{--}}
                        {{--$('.general_file_no').html('');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    });

    //---------------------------------------select 2------------//

    @if (!$request_id)
        var all_req_data = {!! json_encode($user_requestes) !!};
                @if ($step && isset($request_id) && $request_id && isset($user_requestes) && $user_requestes)
        var all_form_request_data = {!! json_encode(collect($user_requestes)->first(function ($value,$key) use($request_id){
                return $value->id == $request_id ;
            })->forms) !!};
                @else
        var all_form_request_data = {} ;
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

    function hide_text_over_flow(el)
    {
        $(el).toggleClass('text_over_flow');
    }
    String.prototype.nums_to_en = function()
    {
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(fa[i], en[i]);
        }
        return r;
    };
    String.prototype.nums_to_fa = function()
    {
        en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        fa = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
        var r = this.toString();
        for (i = 0; i < 10; i++)
        {
            r = r.replace(en[i], fa[i]);
        }
        return r;
    };
</script>
