<script>
    var my_transcript_tasks_calendar = $('.my_transcript_tasks_calendar');
    var my_transcript_tasks_calendar_loaded = false;
    $(document).off('click', '.my_transcript_tasks_tab').on('click', '.my_transcript_tasks_tab', function()
    {
        $('.my_transcript_tasks_trash_buttons').hide();
        $('.my_transcript_tasks_calendar_buttons').hide();
        $('.my_transcript_tasks_buttons').show();
        datatable_reload();
    });
    $(document).off('click', '.my_transcript_tasks_trash_tab').on('click', '.my_transcript_tasks_trash_tab', function()
    {
        $('.my_transcript_tasks_buttons').hide();
        $('.my_transcript_tasks_calendar_buttons').hide();
        $('.my_transcript_tasks_trash_buttons').show();
        datatable_reload_trash();
    });
    $(document).off('click', '.my_transcript_tasks_calendar_tab').on('click', '.my_transcript_tasks_calendar_tab', function()
    {
        $('.my_transcript_tasks_buttons').hide();
        $('.my_transcript_tasks_trash_buttons').hide();
        $('.my_transcript_tasks_calendar_buttons').show();
        calendar_load();
    });
    $(document).off('click', '.btn_trash').on('click', '.btn_trash', function()
    {
        var data = [];
        $.each(window.my_transcript_tasks_rows_selected, function(k, v) { data.push(v.deletion_args); });
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.my_transcript_tasks_trash.trash')}}',
            data: {hashed_ids: data},
            success: function() { datatable_reload(); }
        });
    });
    $(document).off('click', '.btn_restore').on('click', '.btn_restore', function()
    {
        var data = [];
        $.each(window.my_transcript_tasks_trash_rows_selected, function(k, v) { data.push(v.deletion_args); });
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.my_transcript_tasks_trash.restore')}}',
            data: {hashed_ids: data},
            success: function() { datatable_reload_trash(); }
        });
    });
    $(document).off('click', '.btn_delete').on('click', '.btn_delete', function()
    {
        var data = [];
        $.each(window.my_transcript_tasks_trash_rows_selected, function(k, v) { data.push(v.deletion_args); });
        $.ajax
        ({
            type: 'post',
            url: '{{ route('ltm.clients.tasks.my_transcript_tasks_trash.delete')}}',
            data: {hashed_ids: data},
            success: function() { datatable_reload_trash(); }
        });
    });
    function calendar_load()
    {
        my_transcript_tasks_calendar.fullCalendar
        ({
            header: {right: 'today next,prev', center: 'title', left: 'agendaDay,agendaWeek,month'},
            lang: 'fa',
            isJalaali: true,
            isRTL: true,
            editable: false,
            eventLimit: true,
            events: function(start, end, timezone, callback)
            {
                var events = [];
                $.ajax
                ({
                    method: 'post',
                    url: '{!! route('ltm.clients.tasks.my_transcript_tasks_trash.fullcalendar_get') !!}',
                    dataType: 'json',
                    data:
                    {
                        range_start: start.unix(),
                        range_end: end.unix(),
                        calendar_filter_code: $('.calendar_filter_code').val() || '',
                        calendar_filter_subject: $('.calendar_filter_subject').val() || '',
                        calendar_filter_title: $('.calendar_filter_title').val() || '',
                        calendar_filter_assigner: $('.calendar_filter_assigner').val() || -1,
                        calendar_filter_importance: $('.calendar_filter_importance').val() || -1,
                        calendar_filter_immediate: $('.calendar_filter_immediate').val() || -1
                    },
                    success: function(results)
                    {
                        $.each(results, function(k, v)
                        {
                            events.push
                            ({
                                id: v.id,
                                title: v.title,
                                start: v.start,
                                end: v.end,
                                url: v.url,
                                background_color: v.background_color,
                                text_color: v.text_color
                            });
                        });
                        callback(events);
                    }
                });
            },
            eventRender: function(event, element)
            {
                element.removeAttr('href');
                element.css
                ({
                    'border-color': event.background_color,
                    'background-color': event.background_color,
                    'color': event.text_color
                });
                element.find('.fc-title').html(event.title);
                element.find('.fc-content').addClass('jsPanels').attr('data-href', event.url).attr('data-title', '<span class="smaller-80">مشاهده جزئیات</span>' + ' ' + event.title);
            },
            loading: function(isLoading, view)
            {
                if (isLoading)
                {
                    my_transcript_tasks_calendar.parent().append(init_loader_html('لطفا منتظر بمانید...'));
                } else
                {
                    my_transcript_tasks_calendar.parent().find('.total_loader').remove();
                }
            }
        });
        my_transcript_tasks_calendar_loaded = true;
    }
    function calendar_reload()
    {
        if (my_transcript_tasks_calendar_loaded)
        {
            my_transcript_tasks_calendar.fullCalendar('refetchEvents');
        } else
        {
            calendar_load();
        }
    }
    $(document).ready(function()
    {
        datatable_load();
        datatable_load_trash();
    });
</script>
