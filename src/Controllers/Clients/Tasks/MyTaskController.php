<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks;

use Hamahang\LTM\Controllers\Controller;
use Hamahang\LTM\Models\Tasks\ClientChatHistory;
use Hamahang\LTM\Requests\Clients\Tasks\MyTask\Action_Request;
use Hamahang\LTM\Models\Form;
use Hamahang\LTM\Models\FormField;
use Hamahang\LTM\Models\FormFieldResult;
use Hamahang\LTM\Models\Tasks\Task;
use Hamahang\LTM\Models\Tasks\TaskAssignment;
use Hamahang\LTM\Models\Tasks\TaskConfirmation;
use Hamahang\LTM\Models\Tasks\TaskPriority;
use Hamahang\LTM\Models\Tasks\TaskStatus;
use Hamahang\LTM\Models\Tasks\TaskTranscript;
use DataTables;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MyTaskController extends Controller
{
    /**
     * @var int
     */
    //var $auth_id = null;
    //var $auth_user = null;

    /**
     * MyTaskController constructor.
     */
    public function __construct()
    {
        /*
        $this->middleware(function ($request, $next)
        {
            $this->auth_id = auth()->id();
            $this->auth_user = auth()->user();
            return $next($request);
        });
        */
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $assigners = config('laravel_task_manager.user_model')::find(auth()->id())->my_tasks_assigners_for_select2;
        $my_tasks_timer_timeout = Cookie::get('my_tasks_timer_timeout', config('tasks.timer_default_timeout'));
        $my_tasks_calendar_timer_timeout = Cookie::get('my_tasks_calendar_timer_timeout', config('tasks.calendar_timer_default_timeout'));
        $with =
        [
            'assigners' => $assigners,
            'my_tasks_timer_timeout' => $my_tasks_timer_timeout,
            'my_tasks_calendar_timer_timeout' => $my_tasks_calendar_timer_timeout,
        ];
        return view('laravel_task_manager::clients.tasks.my_tasks.index')->with($with);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function datatable_get(Request $request)
    {
        $filters['code'] = trim($request->input('filter_code'));
        $filters['subject'] = trim($request->input('filter_subject'));
        $filters['title'] = trim($request->input('filter_title', null));
        $filters['assigner'] = trim($request->input('filter_assigner', -1));
        $filters['status'] = trim($request->input('filter_status', -1));
        $filters['importance'] = trim($request->input('filter_importance', -1));
        $filters['immediate'] = trim($request->input('filter_immediate', -1));
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $no_filters =
            null == $filters['code'] &&
            null == $filters['subject'] &&
            null == $filters['title'] &&
            -1 == $filters['assigner'] &&
            -1 == $filters['status'] &&
            -1 == $filters['importance'] &&
            -1 == $filters['immediate'];
        if ($no_filters)
        {
            $my_tasks = $user->my_tasks->with('subject')->with('assignment.assigner')->with('priority');
        } else
        {
            if ($filters['title'])
            {
                $my_tasks = $user->my_tasks->whereRaw('CONCAT(ltm_tasks.title, IFNULL(ltm_tasks.description, "")) LIKE ?', ["%$filters[title]%"]);
            } else
            {
                $my_tasks = $user->my_tasks;
            }
            if ($filters['code'])
            {
                $my_tasks = $user->my_tasks->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
            }
            if ($filters['subject'])
            {
                $my_tasks = $my_tasks->with('subject')->whereHas('subject', function($query) use ($filters)
                {
                    $query->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            } else
            {
                $my_tasks = $my_tasks->with('subject');
            }
            if (-1 != $filters['assigner'])
            {
                $my_tasks = $my_tasks->with('assignment.assigner')->whereHas('assignment', function($query) use ($filters)
                {
                    $query->whereHas('assigner', function($query) use ($filters)
                    {
                        $query->where('ltm_task_assignments.assigner_id', $filters['assigner']);
                    });
                });
            } else
            {
                $my_tasks = $my_tasks->with('assignment.assigner');
            }
            if (-1 != $filters['status'])
            {
                $my_tasks = $my_tasks->whereHas('assignments.statuses', function($query) use ($filters)
                {
                    $query->whereRaw('(SELECT MAX(status) FROM ltm_task_statuses AS task_statuses WHERE ltm_task_statuses.status = ?)', [$filters['status']]);
                });
            }
            if (-1 != $filters['importance'])
            {
                $my_tasks = $my_tasks->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.importance', $filters['importance']);
                });
            } else
            {
                $my_tasks = $my_tasks->with('priority');
            }
            if (-1 != $filters['immediate'])
            {
                $my_tasks = $my_tasks->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.immediate', $filters['immediate']);
                });
            } else
            {
                $my_tasks = $my_tasks->with('priority');
            }
        }
        $r = Datatables::eloquent($my_tasks)
            ->editColumn('id', function($data)
            {
                return ltm_encode_ids([$data->id]);
            })
            ->addColumn('subject', function($data)
            {
                return $data->subject->title;
            })
            ->editColumn('title', function($data)
            {
                $route = route('ltm.modals.common.tasks.my_tasks.view');
                $id = ltm_encode_ids([$data->id]);
                $data_reload = true ? 'reload' : null;
                $data_href = "$route?id=$id&t=1";
                $data_title = 'مشاهده جزئیات' . ' ' . $data->title;
                $title = $data->title . ($data->description ? " ({$data->description})" : null);
                $r = "<a class='jsPanels' data-reload='$data_reload' data-href='$data_href' data-title='$data_title'>$title</a>";
                return $r;
            })
            ->addColumn('assigner', function($data)
            {
                return $data->assignment->assigner->full_name;
            })
            ->addColumn('status', function($data)
            {
                /*
                $current_status = $data->assignment->current_status;
                $percent = ' (' . $current_status->percent . '%)';
                return $current_status->status_name . (1 == $current_status->status ? $percent : null);
                */
                $percent = null;//' (' . $data->assignment->statuses->first()->percent . '%)';
                return $data->assignment->current_status->status_name . (1 == $data->assignment->current_status->status ? $percent : null);
            })
            ->addColumn('importance', function($data)
            {
                return $data->employee_priority->importance;
            })
            ->addColumn('immediate', function($data)
            {
                return $data->employee_priority->immediate;
            })
            ->addColumn('visited', function($data)
            {
                return (bool) $data->assignment->visited;
            })
            ->rawColumns(['title'])
            ->make(true);
        return $r;
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Exception
     */
    public function fullcalendar_get(Request $request)
    {
        //dd($request->all());
        $r = [];
        $range_start = gmdate("Y-m-d", $request->input('range_start'));
        $range_end = gmdate("Y-m-d", $request->input('range_end'));
        $filters['code'] = trim($request->input('calendar_filter_code'));
        $filters['subject'] = trim($request->input('calendar_filter_subject'));
        $filters['title'] = trim($request->input('calendar_filter_title', null));
        $filters['assigner'] = trim($request->input('calendar_filter_assigner', -1));
        $filters['importance'] = trim($request->input('calendar_filter_importance', -1));
        $filters['immediate'] = trim($request->input('calendar_filter_immediate', -1));
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $no_filters =
            null == $filters['code'] &&
            null == $filters['title'] &&
            null == $filters['subject'] &&
            -1 == $filters['assigner'] &&
            -1 == $filters['importance'] &&
            -1 == $filters['immediate'];
        if ($no_filters)
        {
            $my_tasks = $user->my_tasks->with('subject')->with('assignment.assigner')->with('priority');
        } else
        {
            if ($filters['title'])
            {
                $my_tasks = $user->my_tasks->whereRaw('CONCAT(ltm_tasks.title, ltm_tasks.description) LIKE ?', ["%$filters[title]%"]);
            } else
            {
                $my_tasks = $user->my_tasks;
            }
            if ($filters['code'])
            {
                $my_tasks = $user->my_tasks->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
            }
            if ($filters['subject'])
            {
                $my_tasks = $my_tasks->with('subject')->whereHas('subject', function($query) use ($filters)
                {
                    $query->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            } else
            {
                $my_tasks = $my_tasks->with('subject');
            }
            if (-1 != $filters['assigner'])
            {
                $my_tasks = $my_tasks->with('assignment.assigner')->whereHas('assignment', function($query) use ($filters)
                {
                    $query->whereHas('assigner', function($query) use ($filters)
                    {
                        $query->where('ltm_task_assignments.assigner_id', $filters['assigner']);
                    });
                });
            } else
            {
                $my_tasks = $my_tasks->with('assignment.assigner');
            }
            if (-1 != $filters['importance'])
            {
                $my_tasks = $my_tasks->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.importance', (int)$filters['importance']);
                });
            } else
            {
                $my_tasks = $my_tasks->with('priority');
            }
            if (-1 != $filters['immediate'])
            {
                $my_tasks = $my_tasks->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.immediate', $filters['immediate']);
                });
            } else
            {
                $my_tasks = $my_tasks->with('priority');
            }
        }
        $my_tasks = $my_tasks->whereRaw('start_time >= ? AND start_time <= ?', ["$range_start 00:00:00", "$range_end 23:59:59"])->get();
        foreach ($my_tasks as $my_task)
        {
            $minutes_to_time = ltm_minutes_to_time($my_task->duration_timestamp);
            $end_datatime = new DateTime($my_task->start_time);
            $date_interval = new \DateInterval($minutes_to_time['strings']['interval']);
            $end = $end_datatime->add($date_interval)->format('Y-m-d H:i:00');
            $id = ltm_encode_ids([$my_task->id]);
            $assignment_id = ltm_encode_ids([$my_task->assignment->id]);
            $r[] =
            [
                'id' => $id,
                'title' => $my_task->title,
                'start' => $my_task->start_time,
                'end' => $end,
                'url' => route('ltm.modals.common.tasks.my_tasks.view') . "?id=$id&t=1&assignment_id=$assignment_id",
                'background_color' => $my_task->subject->background_color,
                'text_color' => $my_task->subject->text_color,
            ];
        }
        return response()->json($r);
    }

    /**
     * @param $task_assignment
     * @param $type
     * @param $request
     * @return array
     */
    function form_fields_result_store_generator($task_assignment, $type, $request)
    {
        //dd($request->toArray());
        $r = [];
        $form_id = null;
        $fields_code = null;
        switch ($type)
        {
            case 'do':
                $form_id = $task_assignment->action_do_form_id;
                $fields_code = $task_assignment->action_do_fields_code;
                break;
            case 'transfer':
                $form_id = $task_assignment->action_transfer_form_id;
                $fields_code = $task_assignment->action_transfer_fields_code;
                break;
            case 'reject':
                $form_id = $task_assignment->action_reject_form_id;
                $fields_code = $task_assignment->action_reject_fields_code;
                break;
            default:
                //for debugging purposes.
                //dd($task_assignment->toArray(), $type, $request);
                break;
        }
        //dd($form_id, $fields_code);
        $fields_data = $request->input($fields_code, []);
        $fields_fields = FormField::where('form_id', $form_id)
            ->select('id', 'type', 'field_id', 'field_name', 'setting')
            ->get();
        foreach ($fields_fields as $fields_field)
        {
            $encoded_id = ltm_encode_ids([$fields_field->id], 8);
            $row['form_field_id'] = $fields_field->id;
            $row['form_field_id'] = $fields_field->id;
            $row['target_table'] = 'Hamahang\LTM\Models\Tasks\TaskAssignment';
            $row['target_id'] = $task_assignment->id;
            $row['type'] = $type;
            switch ($fields_field->type)
            {
                case 'lfm':
                    $section = 'lfm_' . $fields_code . '_' . $fields_field->field_name;
                    if (json_decode($fields_field->setting)->multiple)
                    {
                        $lfm = LFM_SaveMultiFile($task_assignment, $section);
                        $row['value'] = $lfm ? 'multiple: ' . implode(', ', array_keys($lfm['data'])) : null;
                    } else
                    {
                        $row['value'] = LFM_GetDecodeId(LFM_GetSectionFile($section)[0]['file']['id']);
                    }
                    break;
                default:
                    $row['value'] = $fields_data[$encoded_id . '_' . $fields_field->field_name];
                    break;
            }
            $r[] = $row;
        }
        return $r;
    }

    /**
     * @param $task_assignment
     * @param bool $task_log_store
     */
    public function make_status_automatically($task_assignment, $task_log_store = true)
    {
        $assignment = TaskAssignment::where('id', '<', $task_assignment->id)
            ->where('id', $task_assignment->previous_id)
            ->where('task_id', $task_assignment->task_id)
            ->where('employee_id', $task_assignment->assigner_id)
            ->orderBy('id', 'desc')
            ->first();
        if ($assignment)
        {
            if ('0' == $assignment->end_on_assigner_accept && 0 != $task_assignment->previous_id)
            {
                TaskConfirmation::store($assignment->id);
                if ($task_log_store)
                {
                    ltm_task_log_store($task_assignment->task_id, config('task_logs.types.modify.action.do.status'), null, ['old' => 2, 'old_percent' => 0, 'new' => 3, 'new_percent' => 0, 'by' => '-1', ]);
                }
                $this->make_status_automatically($assignment);
            } else
            {
                return;
            }
        } else
        {
            return;
        }
        /*
        */
    }

    /**
     * @param Action_Request $request
     * @return json
     * @throws \Throwable
     */
    public function action(Action_Request $request)
    {
        DB::beginTransaction();
        try
        {
            // initialize general variables.
            $task_id = ltm_decode_ids($request->input('task_id'), 0);
            $task_assignment_id = ltm_decode_ids($request->input('task_assignment_id'), 0);
            $task_assignment = TaskAssignment::where('id', $task_assignment_id)->first();
            $action_type = $request->input('action_type');
            // initialize variables for do.
            $action_do_status_old = $request->input('action_do_status_old');
            $action_do_status = $request->input('action_do_status');
            $action_do_status_changed = $action_do_status_old !== $action_do_status;
            $action_do_status_percent_old = $request->input('action_do_status_percent_old', 0);
            $action_do_status_percent = $request->input('action_do_status_percent', 0);
            $action_do_status_percent_changed = $action_do_status_percent_old !== $action_do_status_percent;
            $action_do_importance_old = $request->input('action_do_importance_old');
            $action_do_importance = $request->input('action_do_importance');
            $action_do_importance_chnanged = $action_do_importance_old !== $action_do_importance;
            $action_do_immediate_old = $request->input('action_do_immediate_old');
            $action_do_immediate = $request->input('action_do_immediate');
            $action_do_immediate_chnanged = $action_do_immediate_old !== $action_do_immediate;
            // initialize variables for transfer.
            $action_transfer_importance = $request->input('action_transfer_importance');
            $action_transfer_immediate = $request->input('action_transfer_immediate');
            $action_transfer_do_form_id = $request->input('action_transfer_do_form_id');
            $action_transfer_transfer_form_id = $request->input('action_transfer_transfer_form_id');
            $action_transfer_reject_form_id = $request->input('action_transfer_reject_form_id');
            $action_transfer_user = $request->input('action_transfer_user');
            $action_transfer_transcripts_cc = $request->input('action_transfer_transcripts_cc', []);
            $action_transfer_transcripts_bcc = $request->input('action_transfer_transcripts_bcc', []);
            /*
            $action_transfer_email = $request->input('action_transfer_email');
            $action_transfer_email_is_active = in_array('is_active', $action_transfer_email ? $action_transfer_email : []);
            $action_transfer_email_users = $action_transfer_email_is_active && in_array('users', $action_transfer_email ? $action_transfer_email : []);
            $action_transfer_email_transcripts = $action_transfer_email_is_active && in_array('transcripts', $action_transfer_email ? $action_transfer_email : []);
            $action_transfer_sms = $request->input('action_transfer_sms');
            $action_transfer_sms_is_active = in_array('is_active', $action_transfer_sms ? $action_transfer_sms : []);
            $action_transfer_sms_users = $action_transfer_sms_is_active && in_array('users', $action_transfer_sms ? $action_transfer_sms : []);
            $action_transfer_sms_transcripts = $action_transfer_sms_is_active && in_array('transcripts', $action_transfer_sms ? $action_transfer_sms : []);
            $action_transfer_messaging = $request->input('action_transfer_messaging');
            $action_transfer_messaging_is_active = in_array('is_active', $action_transfer_messaging ? $action_transfer_messaging : []);
            $action_transfer_messaging_users = $action_transfer_messaging_is_active && in_array('users', $action_transfer_messaging ? $action_transfer_messaging : []);
            $action_transfer_messaging_transcripts = $action_transfer_messaging_is_active && in_array('transcripts', $action_transfer_messaging ? $action_transfer_messaging : []);
            */
            $action_transfer_transferable = (string) (int) (bool) $request->input('action_transfer_transferable', '0');
            $action_transfer_end_on_assigner_accept = (string) (int) (bool) $request->input('action_transfer_end_on_assigner_accept', '0');
            $action_transfer_rejectable = (string) (int) (bool) $request->input('action_transfer_rejectable', '0');
            // status
            switch ($action_type)
            {
                // no changes
                case '-1':
                    if ($action_do_importance_chnanged || $action_do_immediate_chnanged)
                    {
                        TaskPriority::store($task_id, auth()->id(), $action_do_importance, $action_do_immediate);
                        if ($action_do_importance_chnanged)
                        {
                            $description_values =
                                [
                                    'old' => $action_do_importance_old,
                                    'new' => $action_do_importance,
                                    'by' => auth()->id(),
                                ];
                            ltm_task_log_store($task_id, config('task_logs.types.modify.action.do.importance'), null, $description_values);
                        }
                        if ($action_do_immediate_chnanged)
                        {
                            $description_values =
                                [
                                    'old' => $action_do_immediate_old,
                                    'new' => $action_do_immediate,
                                    'by' => auth()->id(),
                                ];
                            ltm_task_log_store($task_id, config('task_logs.types.modify.action.do.immediate'), null, $description_values);
                        }
                    }
                    break;
                // do
                case '1':
                    if ($action_do_importance_chnanged || $action_do_immediate_chnanged)
                    {
                        $task_priority = new TaskPriority();
                        $task_priority->task_id = $task_id;
                        $task_priority->user_id = auth()->id();
                        $task_priority->importance = $action_do_importance;
                        $task_priority->immediate = $action_do_immediate;
                        $task_priority->created_by = auth()->id();
                        $task_priority->save();
                        if ($action_do_importance_chnanged)
                        {
                            $description_values =
                                [
                                    'old' => $action_do_importance_old,
                                    'new' => $action_do_importance,
                                    'by' => auth()->id(),
                                ];
                            ltm_task_log_store($task_id, config('task_logs.types.modify.action.do.importance'), null, $description_values);
                        }
                        if ($action_do_immediate_chnanged)
                        {
                            $description_values =
                                [
                                    'old' => $action_do_immediate_old,
                                    'new' => $action_do_immediate,
                                    'by' => auth()->id(),
                                ];
                            ltm_task_log_store($task_id, config('task_logs.types.modify.action.do.immediate'), null, $description_values);
                        }
                    }
                    if ('-1' !== $action_do_status && ($action_do_status_changed || $action_do_status_percent_changed))
                    {
                        TaskStatus::store($task_assignment_id, TaskStatus::TYPE_EMPLOYEE, $action_do_status, $action_do_status_percent);
                        $description_values =
                            [
                                'old' => $action_do_status_old,
                                'old_percent' => $action_do_status_percent_old,
                                'new' => $action_do_status,
                                'new_percent' => $action_do_status_percent,
                                'by' => auth()->id(),
                            ];
                        ltm_task_log_store($task_id, config('task_logs.types.modify.action.do.status'), 2 == $action_do_status ? $task_assignment_id : null, $description_values);
                        TaskConfirmation::store($task_assignment_id);
                        if (in_array($action_do_status, ['2']))
                        {
                            FormFieldResult::store($this->form_fields_result_store_generator($task_assignment, 'do', $request));
                        }
                        if (in_array($action_do_status, ['2', '3']))
                        {
                            $this->make_status_automatically($task_assignment, false);
                        }
                    }
                    break;
                // transfer
                case '2':
                    // assignment > update
                    $description_values_transcripts = [];
                    $assignment = Task::where('id', $task_id)->first()->assignments()->where('ltm_task_assignments.employee_id', auth()->id())->where('ltm_task_assignments.transferred_to_id', '0')->where('ltm_task_assignments.transmitter_id', '0')->where('ltm_task_assignments.integrated_task_id', '0')->whereNull('ltm_task_assignments.rejected_at')->first();
                    $assignment->transmitter_id = auth()->id();
                    $assignment->transferred_to_id = $action_transfer_user;
                    $assignment->save();
                    // assignment > insert
                    $insert_assignment = new TaskAssignment();
                    $insert_assignment->task_id = $task_id;
                    $insert_assignment->previous_id = $assignment->id;
                    $insert_assignment->assigner_id = auth()->id();
                    $insert_assignment->employee_id = $action_transfer_user;
                    $insert_assignment->transmitter_id = 0;
                    $insert_assignment->transferred_to_id = 0;
                    $insert_assignment->integrated_task_id = 0;
                    $insert_assignment->rejected_at = null;
                    $insert_assignment->action_do_form_id = $action_transfer_do_form_id;
                    if ($action_transfer_do_form_id) { $insert_assignment->action_do_fields_code = Form::generate_fields_code($action_transfer_do_form_id); }
                    $insert_assignment->action_transfer_form_id = $action_transfer_transfer_form_id;
                    if ($action_transfer_transfer_form_id) { $insert_assignment->action_transfer_fields_code = Form::generate_fields_code($action_transfer_transfer_form_id); }
                    $insert_assignment->action_reject_form_id = $action_transfer_reject_form_id;
                    if ($action_transfer_reject_form_id) { $insert_assignment->action_reject_fields_code = Form::generate_fields_code($action_transfer_reject_form_id); }
                    $insert_assignment->transferable = $action_transfer_transferable;
                    $insert_assignment->end_on_assigner_accept = $action_transfer_end_on_assigner_accept;
                    $insert_assignment->rejectable = $action_transfer_rejectable;
                    $insert_assignment->created_by = auth()->id();
                    $insert_assignment->save();
                    // status
                    $task_status = new TaskStatus();
                    $task_status->task_assignment_id = $insert_assignment->id;
                    $task_status->type = TaskStatus::TYPE_ASSIGNER;
                    $task_status->status = 0;
                    $task_status->percent = 0;
                    $task_status->created_by = auth()->id();
                    $task_status->save();

                    // priority
                    foreach ([[auth()->id(), $action_transfer_importance, $action_transfer_immediate], [$action_transfer_user, $action_transfer_importance, $action_transfer_immediate]] as $task_auth_and_employee_data)
                    {
                        $task_priority = new TaskPriority();
                        $task_priority->task_id = $task_id;
                        $task_priority->user_id = $task_auth_and_employee_data[0];
                        $task_priority->importance = $task_auth_and_employee_data[1];
                        $task_priority->immediate = $task_auth_and_employee_data[2];
                        $task_priority->created_by = auth()->id();
                        $task_priority->save();
                    }
                    // transcript_cc
                    foreach ($action_transfer_transcripts_cc as $user_id)
                    {
                        $task_transcript = new TaskTranscript();
                        $task_transcript->task_assignment_id = $insert_assignment->id;
                        $task_transcript->user_id = $user_id;
                        $task_transcript->type = 'Cc';
                        $task_transcript->is_active = '1';
                        $task_transcript->created_by = auth()->id();
                        $task_transcript->trashed_at = null;
                        $task_transcript->save();
                        $user = config('laravel_task_manager.user_model')::find($user_id);
                        array_push($description_values_transcripts, $user->full_name);
                    }
                    // transcript_bcc
                    foreach ($action_transfer_transcripts_bcc as $user_id)
                    {
                        $task_transcript = new TaskTranscript();
                        $task_transcript->task_assignment_id = $insert_assignment->id;
                        $task_transcript->user_id = $user_id;
                        $task_transcript->type = 'Bcc';
                        $task_transcript->is_active = '1';
                        $task_transcript->created_by = auth()->id();
                        $task_transcript->trashed_at = null;
                        $task_transcript->save();
                    }
                    // log
                    $description_values =
                        [
                            'transmitter' => auth()->id(),
                            'from' => $assignment->employee_id,
                            'to' => $action_transfer_user,
                            'transcripts' => serialize($description_values_transcripts),
                        ];
                    ltm_task_log_store($task_id, config('task_logs.types.modify.action.transfer'), $task_assignment_id, $description_values);
                    // forms
                    FormFieldResult::store($this->form_fields_result_store_generator($task_assignment, 'transfer', $request));
                    break;
                // reject
                case '3':
                    // assignment > update
                    $assignment = Task::where('id', $task_id)->first()->assignments()->where('ltm_task_assignments.employee_id', auth()->id())->where('ltm_task_assignments.transferred_to_id', '0')->where('ltm_task_assignments.transmitter_id', '0')->where('ltm_task_assignments.integrated_task_id', '0')->whereNull('ltm_task_assignments.rejected_at')->first();
                    $assignment->rejected_at = date('Y-m-d H:i:00');
                    $assignment->save();
                    $description_values =
                        [
                            'by' => auth()->id(),
                        ];
                    ltm_task_log_store($task_id, config('task_logs.types.modify.action.reject'), $task_assignment_id, $description_values);
                    FormFieldResult::store($this->form_fields_result_store_generator($task_assignment, 'reject', $request));
                    break;
            }

            DB::commit();
            return $this->action_success();
        } catch (\Exception $e)
        {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1']))
            {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status'  => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }

    public function save_track(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $assignment_id = ltm_decode_ids($request->input('assignment_id'), 0);
            $chat = new ClientChatHistory();
            $chat->assignment_id = $assignment_id;
            $chat->description = $request->description_track;
            $chat->is_message_from_client = '1';
            $chat->user_id = auth()->id();
            $chat->save();
            $itemFile = LFM_SaveSingleFile($chat, 'file_id', 'attachment_track');
            $chats = ClientChatHistory::with('user')->where('assignment_id',$assignment_id)->get() ;
            $LFM_options = ['size_file' => 1000 * 1000 * 4, 'max_file_number' => 1, 'true_file_extension' => ['zip', 'rar','png', 'jpg'], 'path' => 'task/chat', 'show_file_uploaded' => 'original'];
            $file = LFM_CreateModalUpload('attachment_track', 'callback_track', $LFM_options, 'result_track', 'UploadFileManager_Track', false, 'result_track_button', 'آپلود فایل')['json'];
            $old_file = [] ;

            $is_final_assigment = true ;
            $track_view = view('laravel_task_manager::modals.tasks.my_tasks.view.track')
                ->with('chats',$chats)
                ->with('file',$file)
                ->with('old_file',json_encode($old_file))
                ->with('is_final_assigment',$is_final_assigment)
                ->with('assignment_id' , ltm_encode_ids([$assignment_id]))
                ->render();
            $res =
                [
                    'success' => true,
                    'track_view' => $track_view,
                    'status_type' => 'success',
                    'message' => 'با موفقیت انجام شد.',
                    'reload' => true,
                ];
            DB::commit();
            return response()->json($res);
        } catch (\Exception $e)
        {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1']))
            {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status'  => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }

    /**
     * @return json
     */
    function action_success()
    {
        $r =
        [
            'status' => true,
            'status_type' => 'success',
            'message' => 'با موفقیت انجام شد.',
            'reload' => true,
        ];
        return response()->json($r, 200)->withHeaders(['content-type' => 'text/plain', 'charset' => 'utf-8']);
    }

    /**
     * @param Request $request
     */
    function save_timeout(Request $request)
    {
        $tab = $request->input('tab');
        $seconds = $request->input('seconds');
        switch ($tab)
        {
            case '1':
                Cookie::queue('my_tasks_timer_timeout', $seconds);
                break;
            case '2':
                Cookie::queue('my_tasks_calendar_timer_timeout', $seconds);
                break;
        }
    }
}
