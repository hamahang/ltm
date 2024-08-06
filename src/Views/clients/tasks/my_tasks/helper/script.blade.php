<script>
    var ecn_tabs = '.tabs';
    var ecn_btn_integrate = '.btn_integrate';
    var ecn_btn_calendar_filter = '.btn_calendar_filter';
    var ecn_calendar_filter = '.calendar_filter';
    var ecn_btn_calendar_filter_apply = '.btn_calendar_filter_apply';
    var ecn_btn_calendar_filter_clear = '.btn_calendar_filter_clear';
    var ecn_my_tasks_timer_control = '.my_tasks_timer_control';
    var ecn_my_tasks_timer_label = '.my_tasks_timer_label';
    var ecn_my_tasks_calendar_timer_control = '.my_tasks_calendar_timer_control';
    var ecn_my_tasks_calendar_timer_label = '.my_tasks_calendar_timer_label';
    var ecn_my_tasks_timer = '.my_tasks_timer';
    var ecn_my_tasks_calendar_timer = '.my_tasks_calendar_timer';

    var e_tabs = $(ecn_tabs);
    var e_btn_integrate = $(ecn_btn_integrate);
    var e_btn_calendar_filter = $(ecn_btn_calendar_filter);
    var e_calendar_filter = $(ecn_calendar_filter);
    var e_btn_calendar_filter_apply = $(ecn_btn_calendar_filter_apply);
    var e_btn_calendar_filter_clear = $(ecn_btn_calendar_filter_clear);
    var e_my_tasks_timer_control = $(ecn_my_tasks_timer_control);
    var e_my_tasks_timer_label = $(ecn_my_tasks_timer_label);
    var e_my_tasks_calendar_timer_control = $(ecn_my_tasks_calendar_timer_control);
    var e_my_tasks_calendar_timer_label = $(ecn_my_tasks_calendar_timer_label);
    var e_ecn_my_tasks_timer = $(ecn_my_tasks_timer);
    var e_ecn_my_tasks_calendar_timer = $(ecn_my_tasks_calendar_timer);

    var my_tasks_calendar = $('.my_tasks_calendar');

    var my_tasks_calendar_loaded = false;


    var my_tasks_timer;
    var my_tasks_timer_counter = my_tasks_timer_timeout = {!! $my_tasks_timer_timeout !!};
    var my_tasks_calendar_timer;
    var my_tasks_calendar_timer_counter = my_tasks_calendar_timer_timeout = {!! $my_tasks_calendar_timer_timeout !!};
    var my_tasks_route = '{{ route('ltm.clients.tasks.my_tasks.datatable_get') }}';

    window['my_tasks_grid_columns'] =
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
            'data': 'code',
            'name': 'code'
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
            'title': 'ارجاع دهنده',
            'data': 'last_employ',
            'name': 'last_employ'
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
            'data': 'description',
            'name': 'description'
        }
    ];
    function datatable_load(filter_code, filter_subject, filter_title, filter_assigner, filter_status, filter_importance, filter_immediate)
    {
        $(ecn_btn_integrate).attr('disabled', 'disabled');
        filter_code = filter_code || '';
        filter_subject = filter_subject || '';
        filter_title = filter_title || '';
        filter_assigner = filter_assigner || -1;
        filter_status = filter_status || -1;
        filter_importance = filter_importance || -1;
        filter_immediate = filter_immediate || -1;
        data =
        {
            filter_code: filter_code,
            filter_subject: filter_subject,
            filter_title: filter_title,
            filter_assigner: filter_assigner,
            filter_status: filter_status,
            filter_importance: filter_importance,
            filter_immediate: filter_immediate,
        };
        function datatable_checkbox_change(data)
        {
            if (data.length < 2)
            {
                e_btn_integrate.removeAttr('data-href');
                e_btn_integrate.attr('disabled', 'disabled');
            } else
            {
                e_btn_integrate.removeAttr('data-href');
                var hashed_ids_array = [];
                $.each(window.my_tasks_rows_selected, function(k, v) { hashed_ids_array.push(v.id); });
                var href = '{!! route('ltm.modals.common.tasks.task.integrate') . '?hashed_ids_array=' !!}' + hashed_ids_array;
                e_btn_integrate.attr('data-href', href);
                e_btn_integrate.removeAttr('disabled');
            }
        }

        dataTablesGrid('.my_tasks', 'my_tasks', my_tasks_route, my_tasks_grid_columns, data, null, true, null, null, 1, null, true, datatable_checkbox_change);
        $('.my_tasks thead').append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_code" style="direction: ltr;" value="' + filter_code + '">' +
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
        $('.calendar_filter_assigner').select2({ data: {!! $assigners !!} }).val(calendar_filter_assigner);
    }
    function datatable_reload()
    {
        var filter_code = $('.filter_code').val();
        var filter_subject = $('.filter_subject').val();
        var filter_title = $('.filter_title').val();
        var filter_assigner = $('.filter_assigner').val();
        var filter_status = $('.filter_status').val();
        var filter_importance = $('.filter_importance').val();
        var filter_immediate = $('.filter_immediate').val();
        my_tasks_timer_reset(my_tasks_timer_timeout);
        my_tasks.destroy();
        $('.my_tasks').empty();
        datatable_load(filter_code, filter_subject, filter_title, filter_assigner, filter_status, filter_importance, filter_immediate);
    }
    function calendar_load()
    {
        my_tasks_calendar.fullCalendar
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
                    url: '{!! route('ltm.clients.tasks.my_tasks.fullcalendar_get') !!}',
                    dataType: 'json',
                    data:
                    {
                        range_start: start.unix(),
                        range_end: end.unix(),
                        calendar_filter_code: $('.calendar_filter_code').val() || '',
                        calendar_filter_subject: $('.calendar_filter_subject').val() || '',
                        calendar_filter_title: $('.calendar_filter_title').val() || '',
                        calendar_filter_assigner: $('.calendar_filter_assigner').val() || -1,
                        calendar_filter_status: $('.calendar_filter_status').val() || -1,
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
                    my_tasks_calendar.parent().append(init_loader_html('لطفا منتظر بمانید...'));
                } else
                {
                    my_tasks_calendar.parent().find('.total_loader').remove();
                }
            }
        });
        my_tasks_calendar_loaded = true;
    }
    function calendar_reload()
    {
        if (my_tasks_calendar_loaded)
        {
            my_tasks_calendar.fullCalendar('refetchEvents');
        } else
        {
            calendar_load();
        }
        my_tasks_calendar_timer_reset(my_tasks_calendar_timer_timeout);
    }
    $(document).off('change', '.filter_assigner, .filter_status, .filter_importance, .filter_immediate').on('change', '.filter_assigner, .filter_status, .filter_importance, .filter_immediate', datatable_reload);
    $(document).off('click', ecn_btn_calendar_filter).on('click', ecn_btn_calendar_filter, function()
    {
        switch (e_calendar_filter.attr('data-status'))
        {
            case '0':
                e_calendar_filter.show().attr('data-status', '1');
                e_btn_calendar_filter.removeClass('btn-default').addClass('btn-secondary');
                break;
            case '1':
                e_calendar_filter.hide().attr('data-status', '0');
                e_btn_calendar_filter.removeClass('btn-secondary').addClass('btn-default');
                break;
        }
    });
    $(document).off('click', ecn_tabs).on('click', ecn_tabs, function()
    {
        switch ($(this).data('tab'))
        {
            case 'my_tasks_tab':
                e_btn_integrate.show();
                e_ecn_my_tasks_timer.show();
                e_btn_calendar_filter.hide();
                e_ecn_my_tasks_calendar_timer.hide();
                //datatable_reload();
                break;
            case 'my_tasks_calendar_tab':
                e_btn_integrate.hide();
                e_ecn_my_tasks_timer.hide();
                e_btn_calendar_filter.show();
                e_ecn_my_tasks_calendar_timer.show();
                if (!my_tasks_calendar_loaded)
                {
                    my_tasks_calendar_timer_start();
                    calendar_load();
                }
                break;
        }
    });
    $(document).off('click', ecn_btn_calendar_filter_clear).on('click', ecn_btn_calendar_filter_clear, function()
    {
        $("input[name^='calendar_filter_']").val('');
        $("select[name^='calendar_filter_']").prop('selectedIndex', 0);
        $('.calendar_filter_assigner').select2({'val': '-1', 'text': 'همه'});
        my_tasks_calendar.fullCalendar('refetchEvents');
    });
    $(document).off('click', ecn_btn_calendar_filter_apply).on('click', ecn_btn_calendar_filter_apply, function()
    {
        my_tasks_calendar.fullCalendar('refetchEvents');
    });
    init_doAfterStopTyping('.filter_code, .filter_subject, .filter_title', datatable_reload);
    $(document).off('click', '.my_tasks_timer_button').on('click', '.my_tasks_timer_button', function()
    {
        status = e_my_tasks_timer_control.data('status');
        switch (status)
        {
            case 'playing':
                my_tasks_timer_stop();
                break;
            case 'paused':
                my_tasks_timer_start();
                break;
        }
    });
    $(document).off('click', '.my_tasks_calendar_timer_button').on('click', '.my_tasks_calendar_timer_button', function()
    {
        status = e_my_tasks_calendar_timer_control.data('status');
        switch (status)
        {
            case 'playing':
                my_tasks_calendar_timer_stop();
                break;
            case 'paused':
                my_tasks_calendar_timer_start();
                break;
        }
    });
    function number_to_hhmmss(i)
    {
        var n = parseInt(i, 10);
        var h = Math.floor(n / 3600);
        var m = Math.floor((n - (h * 3600)) / 60);
        var s = n - (h * 3600) - (m * 60);
        if (h < 10) {h = '0' + h;}
        if (m < 10) {m = '0' + m;}
        if (s < 10) {s = '0' + s;}
        r = h + ':' + m + ':' + s;
        return r;
    }
    function my_tasks_timer_tick()
    {
        hhmmss = number_to_hhmmss(my_tasks_timer_counter);
        if (0 === my_tasks_timer_counter)
        {
            $(e_my_tasks_timer_label).html(hhmmss);
            my_tasks_timer_counter = my_tasks_timer_timeout;
            datatable_reload();
        } else
        {
            $(e_my_tasks_timer_label).html(hhmmss);
            my_tasks_timer_counter--;
        }
    }
    function my_tasks_timer_start()
    {
        my_tasks_timer = window.setInterval(my_tasks_timer_tick, 1000);
        e_my_tasks_timer_control.data('status', 'playing').removeClass('fa-play').addClass('fa-pause');
    }
    function my_tasks_timer_stop()
    {
        window.clearInterval(my_tasks_timer);
        e_my_tasks_timer_control.data('status', 'paused').removeClass('fa-pause').addClass('fa-play');
    }
    function my_tasks_timer_reset(seconds, thic)
    {
        my_tasks_timer_stop();
        my_tasks_timer_timeout = my_tasks_timer_counter = seconds;
        my_tasks_timer_tick();
        my_tasks_timer_start();
        $('.my_tasks_timer_selector_item').removeClass('active');
        $(thic).addClass('active');
    }
    function my_tasks_calendar_timer_tick()
    {
        hhmmss = number_to_hhmmss(my_tasks_calendar_timer_counter);
        if (0 === my_tasks_calendar_timer_counter)
        {
            $(e_my_tasks_calendar_timer_label).html(hhmmss);
            my_tasks_calendar_timer_counter = my_tasks_calendar_timer_timeout;
            calendar_reload();
        } else
        {
            $(e_my_tasks_calendar_timer_label).html(hhmmss);
            my_tasks_calendar_timer_counter--;
        }
    }
    function my_tasks_calendar_timer_start()
    {
        my_tasks_calendar_timer = window.setInterval(my_tasks_calendar_timer_tick, 1000);
        e_my_tasks_calendar_timer_control.data('status', 'playing').removeClass('fa-play').addClass('fa-pause');
    }
    function my_tasks_calendar_timer_stop()
    {
        window.clearInterval(my_tasks_calendar_timer);
        e_my_tasks_calendar_timer_control.data('status', 'paused').removeClass('fa-pause').addClass('fa-play');
    }
    function my_tasks_calendar_timer_reset(seconds, thic)
    {
        my_tasks_calendar_timer_stop();
        my_tasks_calendar_timer_timeout = my_tasks_calendar_timer_counter = seconds;
        my_tasks_calendar_timer_tick();
        my_tasks_calendar_timer_start();
        $('.my_tasks_calendar_timer_selector_item').removeClass('active');
        $(thic).addClass('active');

    }
    function save_timeout(tab, seconds)
    {
        $.ajax
        ({
            method: 'post',
            url: '{!! route('ltm.clients.tasks.my_tasks.save_timeout') !!}',
            data:
            {
                'tab': tab,
                'seconds': seconds
            },
            success: function(results)
            {

            }
        });
    }
    $(document).ready(function()
    {
        my_tasks_timer_start();
        setTimeout(function(){
            datatable_load();
        },500)
    });
</script>
