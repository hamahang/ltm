@if ($log->assignment)
    @php
        switch ($log->type)
        {
            case '2':
                $results = $log->assignment->action_do_form_results;
                break;
            case '5':
                $results = $log->assignment->action_transfer_form_results;
                break;
            case '6':
                $results = $log->assignment->action_reject_form_results;
                break;
        }
        $random = $log->type . rand(100000, 999999);
    @endphp
    @if ($results->count())
        <div class="btn btn-default" onclick="$('.more_action_{!! $random !!}_details_toggle').toggle();">نمایش جزئیات بیشتر</div>
        <table class="table more_action_{!! $random !!}_details_toggle" style="margin-top: 20px; display: none;">
            @foreach ($results as $result)
                <tr>
                    <td>{!! $result->form_field->label_title !!}</td>
                    @php
                        if ('lfm' == $result->form_field->type)
                        {
                            if (json_decode($result->form_field->setting)->multiple)
                            {
                                $task_assignment = \ArtinCMS\LTM\Models\Tasks\TaskAssignment::find($log->task_assignment_id);
                                $files = LFM_ShowMultiFile($task_assignment);
                                print("<td>{$files['view']['small']}</td>");
                            } else
                            {
                                $files = LFM_ShowingleFile($result, 'value');
                                print("<td>{$files['view']['small']}</td>");
                            }
                        } else
                        {
                            print("<td>$result->value</td>");
                        }
                    @endphp
                </tr>
            @endforeach
        </table>
    @endif
@endif
