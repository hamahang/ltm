<script>
    var ecn_tabs = '.tabs';
    var ecn_btn_calendar_filter = '.btn_calendar_filter';
    var ecn_calendar_filter = '.calendar_filter';
    var ecn_btn_calendar_filter_apply = '.btn_calendar_filter_apply';
    var ecn_btn_calendar_filter_clear = '.btn_calendar_filter_clear';
    var ecn_my_assigned_tasks_timer_control = '.my_assigned_tasks_timer_control';
    var ecn_my_assigned_tasks_timer_label = '.my_assigned_tasks_timer_label';
    var ecn_my_assigned_tasks_calendar_timer_control = '.my_assigned_tasks_calendar_timer_control';
    var ecn_my_assigned_tasks_calendar_timer_label = '.my_assigned_tasks_calendar_timer_label';
    var ecn_my_assigned_tasks_timer = '.my_assigned_tasks_timer';
    var ecn_my_assigned_tasks_calendar_timer = '.my_assigned_tasks_calendar_timer';

    var e_tabs = $(ecn_tabs);
    var e_btn_calendar_filter = $(ecn_btn_calendar_filter);
    var e_calendar_filter = $(ecn_calendar_filter);
    var e_btn_calendar_filter_apply = $(ecn_btn_calendar_filter_apply);
    var e_btn_calendar_filter_clear = $(ecn_btn_calendar_filter_clear);
    var e_my_assigned_tasks_timer_control = $(ecn_my_assigned_tasks_timer_control);
    var e_my_assigned_tasks_timer_label = $(ecn_my_assigned_tasks_timer_label);
    var e_my_assigned_tasks_calendar_timer_control = $(ecn_my_assigned_tasks_calendar_timer_control);
    var e_my_assigned_tasks_calendar_timer_label = $(ecn_my_assigned_tasks_calendar_timer_label);
    var e_ecn_my_assigned_tasks_timer = $(ecn_my_assigned_tasks_timer);
    var e_ecn_my_assigned_tasks_calendar_timer = $(ecn_my_assigned_tasks_calendar_timer);

    var my_assigned_tasks_calendar = $('.my_assigned_tasks_calendar');

    var my_assigned_tasks_calendar_loaded = false;


    var my_assigned_tasks_timer;
    var my_assigned_tasks_timer_counter = my_assigned_tasks_timer_timeout = 0;
    var my_assigned_tasks_calendar_timer;
    var my_assigned_tasks_calendar_timer_counter = my_assigned_tasks_calendar_timer_timeout = 0;
    var my_assigned_tasks_route = '{{ route('ltm.clients.tasks.my_assigned_tasks.datatable_get') }}';








    window['my_assigned_tasks_grid_columns'] =
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
            'name': 'task.code'
        },
        {
            'title': 'موضوع',
            'data': 'subject',
            'name': 'task.subject.title'
        },
        {
            'title': 'عنوان',
            'data': 'title',
            'name': 'task.title',
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
            'data': 'description',
            'name': 'task.description'
        }
    ];
    function datatable_load(filter_code, filter_subject, filter_title, filter_employee, filter_status, filter_importance, filter_immediate)
    {
        filter_code = filter_code || '';
        filter_subject = filter_subject || '';
        filter_title = filter_title || '';
        filter_employee = filter_employee || -1;
        filter_status = filter_status || -1;
        filter_importance = filter_importance || -1;
        filter_immediate = filter_immediate || -1;
        data =
        {
            filter_code: filter_code,
            filter_subject: filter_subject,
            filter_title: filter_title,
            filter_employee: filter_employee,
            filter_status: filter_status,
            filter_importance: filter_importance,
            filter_immediate: filter_immediate
        };
        dataTablesGrid('.my_assigned_tasks', 'my_assigned_tasks', my_assigned_tasks_route, my_assigned_tasks_grid_columns, data, null, true, null, null, 1, null, true);
        $('.my_assigned_tasks thead').append
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
        $('.filter_employee').select2({ data: {!! $employees !!} }).val(filter_employee);
        $('.calendar_filter_employee').select2({ data: {!! $employees !!} }).val(calendar_filter_employee);
    }
    function datatable_reload()
    {
        var filter_code = $('.filter_code').val();
        var filter_subject = $('.filter_subject').val();
        var filter_title = $('.filter_title').val();
        var filter_employee = $('.filter_employee').val();
        var filter_status = $('.filter_status').val();
        var filter_importance = $('.filter_importance').val();
        var filter_immediate = $('.filter_immediate').val();
        my_assigned_tasks.destroy();
        $('.my_assigned_tasks').empty();
        datatable_load(filter_code, filter_subject, filter_title, filter_employee, filter_status, filter_importance, filter_immediate);
    }
    function calendar_load()
    {
        my_assigned_tasks_calendar.fullCalendar
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
                    url: '{!! route('ltm.clients.tasks.my_assigned_tasks.fullcalendar_get') !!}',
                    dataType: 'json',
                    data:
                    {
                        range_start: start.unix(),
                        range_end: end.unix(),
                        calendar_filter_code: $('.calendar_filter_code').val() || '',
                        calendar_filter_subject: $('.calendar_filter_subject').val() || '',
                        calendar_filter_title: $('.calendar_filter_title').val() || '',
                        calendar_filter_employee: $('.calendar_filter_employee').val() || -1,
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
                    my_assigned_tasks_calendar.parent().append(init_loader_html('لطفا منتظر بمانید...'));
                } else
                {
                    my_assigned_tasks_calendar.parent().find('.total_loader').remove();
                }
            }
        });
        my_assigned_tasks_calendar_loaded = true;
    }
    function calendar_reload()
    {
        if (my_assigned_tasks_calendar_loaded)
        {
            my_assigned_tasks_calendar.fullCalendar('refetchEvents');
        } else
        {
            calendar_load();
        }
        my_assigned_tasks_calendar_timer_reset(my_assigned_tasks_calendar_timer_timeout);
    }
    $(document).off('change', '.filter_employee, .filter_status, .filter_importance, .filter_immediate').on('change', '.filter_employee, .filter_status, .filter_importance, .filter_immediate', datatable_reload);
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
            case 'my_assigned_tasks_tab':
                e_ecn_my_assigned_tasks_timer.show();
                e_btn_calendar_filter.hide();
                e_ecn_my_assigned_tasks_calendar_timer.hide();
                //datatable_reload();
                break;
            case 'my_assigned_tasks_calendar_tab':
                e_ecn_my_assigned_tasks_timer.hide();
                e_btn_calendar_filter.show();
                e_ecn_my_assigned_tasks_calendar_timer.show();
                if (!my_assigned_tasks_calendar_loaded)
                {
                    calendar_load();
                }
                break;
        }
    });
    $(document).off('click', ecn_btn_calendar_filter_clear).on('click', ecn_btn_calendar_filter_clear, function()
    {
        $("input[name^='calendar_filter_']").val('');
        $("select[name^='calendar_filter_']").prop('selectedIndex', 0);
        $('.calendar_filter_employee').select2({'val': '-1', 'text': 'همه'});
        my_assigned_tasks_calendar.fullCalendar('refetchEvents');
    });
    $(document).off('click', ecn_btn_calendar_filter_apply).on('click', ecn_btn_calendar_filter_apply, function()
    {
        my_assigned_tasks_calendar.fullCalendar('refetchEvents');
    });
    init_doAfterStopTyping('.filter_code, .filter_subject, .filter_title', datatable_reload);
    $(document).ready(function()
    {
        datatable_load();
    });
</script>
