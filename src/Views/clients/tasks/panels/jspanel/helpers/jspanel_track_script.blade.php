<script>
    $(document).ready(function () {
        var form = document.querySelector('#form_track_task_{{$variable}}');
        var constraints =
            {
                description:
                    {
                        presence: {message: '^<strong>توضیحات الزامی است</strong>'}
                    }
            };
        function task_track_add(formElement)
        {
            var formData = new FormData(formElement);
            $.ajax
            ({
                type: 'post',
                url: '{{ route('ltm.clients.tasks.panels.send_response')}}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result)
                {
                    $('#form_track_task_{{$variable}} .total_loader').remove();
                    if (result.success)
                    {
                        clear_form_elements('#form_track_task_{{$variable}}');
                        $('#result_track').html('');
                        $('#li_task_tracking').addClass('hidden');
                        $('#btn_insert_task_{{$variable}}').removeClass('hidden') ;
                        $('#btn_insert_track_task_{{$variable}}').addClass('hidden') ;
                        $('a[href="#task_manage"]').click();
                    }
                    else
                    {
                        showMessages(result.message, 'form_message_box_track_{{$variable}}', 'error', formElement);
                        showErrors(form, result.errors);
                    }
                }
            }).fail(function(result)
            {
                alert('خطای ' + result.statusText);
                $('.total_loader').remove();
            });
        }
        init_validatejs(form, constraints, task_track_add, '#form_track_task_{{$variable}}',true);
    });

</script>
