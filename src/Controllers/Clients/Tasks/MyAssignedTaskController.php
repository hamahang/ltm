<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks;

use Hamahang\LTM\Controllers\Controller;
use DataTables;
use DateTime;
use Illuminate\Http\Request;

/**
 * Class MyAssignedTaskController
 * @package Hamahang\LTM\Controllers\Clients\Tasks
 */
class MyAssignedTaskController extends Controller
{
    /**
     * MyAssignedTaskController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $employees = config('laravel_task_manager.user_model')::find(auth()->id())->my_assigned_tasks_employees_for_select2;

        return view('laravel_task_manager::clients.tasks.my_assigned_tasks.index')->with(['employees' => json_encode($employees)]);
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
        $filters['employee'] = trim($request->input('filter_employee', -1));
        $filters['status'] = trim($request->input('filter_status', -1));
        $filters['importance'] = trim($request->input('filter_importance', -1));
        $filters['immediate'] = trim($request->input('filter_immediate', -1));
        $no_filters =
            null == $filters['code'] &&
            null == $filters['title'] &&
            null == $filters['subject'] &&
            -1 == $filters['employee'] &&
            -1 == $filters['status'] &&
            -1 == $filters['importance'] &&
            -1 == $filters['immediate'];
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $my_assignments = $user->my_assigned_tasks_assignments();

        if ($no_filters)
        {
            $my_assignments = $my_assignments->with(['task.subject', 'employee', 'task.priority']);
        }
        else
        {
            if ($filters['title'])
            {
                $my_assignments = $my_assignments->whereHas('task', function ($q) use ($filters) {
                    $q->whereRaw('CONCAT(ltm_tasks.title, IFNULL(ltm_tasks.description, "")) LIKE ?', ["%$filters[title]%"]);
                });
            }
            if ($filters['code'])
            {
                $my_assignments = $my_assignments->whereHas('task', function ($q) use ($filters) {
                    $q->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
                });
            }
            if ($filters['subject'])
            {
                $my_assignments = $my_assignments->with('task.subject')->whereHas('task.subject', function ($q) use ($filters) {
                    $q->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            }
            else
            {
                $my_assignments = $my_assignments->with('task.subject');
            }
            if (-1 != $filters['status'])
            {
                $my_assignments = $my_assignments->whereHas('statuses', function($query) use ($filters)
                {
                    $query->whereRaw('(SELECT MAX(status) FROM ltm_task_statuses AS task_statuses WHERE ltm_task_statuses.status = ?)', [$filters['status']]);
                });
            }
            if (-1 != $filters['employee'])
            {
                $my_assignments = $my_assignments->where('employee_id', $filters['employee']);
            }
            else
            {
                $my_assignments = $my_assignments->with('employee');
            }

            if (-1 != $filters['importance'] && -1 != $filters['immediate'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.importance', $filters['importance'])
                        ->where('ltm_task_priorities.immediate', $filters['immediate'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            elseif (-1 != $filters['importance'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.importance', $filters['importance'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            elseif (-1 != $filters['immediate'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.immediate', $filters['immediate'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            else
            {
                $my_assignments = $my_assignments->with('task.priority');
            }
        }

        $r = Datatables::eloquent($my_assignments)
            ->editColumn('id', function ($data) {
                return ltm_encode_ids([$data->id]);
            })
            ->addColumn('code', function ($data) {
                return $data->task->code;
            })
            ->addColumn('title', function ($data) {
                return $data->task->title;
            })
            ->addColumn('description', function ($data) {
                return $data->task->description;
            })
            ->addColumn('subject', function ($data) {
                return $data->task->subject->title;
            })
            ->editColumn('title', function ($data) {
                $route = route('ltm.modals.common.tasks.my_assigned_tasks.view');
                $data_reload = true ? 'reload' : null;
                $data_href = "$route?assignment_id={$data->encoded_id}&t=2";
                $data_title = 'مشاهده جزئیات' . ' ' . $data->task->title;
                $title = $data->task->title . ($data->task->description ? " ({$data->task->description})" : null);
                $r = "<a class='jsPanels' data-reload='$data_reload' data-href='$data_href' data-title='$data_title'>$title</a>";

                return $r;
            })
            ->addColumn('employee', function ($data) {
                return $data->employee->full_name;
            })
            ->addColumn('status', function ($data) {
                $percent = ' (' . (isset($data->statuses->first()->percent) ? $data->statuses->first()->percent : 0) . '%)';

                if (isset($data->statuses->first()->status_name))
                {
                    return $data->statuses->first()->status_name . (1 == $data->statuses->first()->status ? $percent : null);
                }
            })
            ->addColumn('importance', function ($data) {
                return $data->assigner_priority->importance;
            })
            ->addColumn('immediate', function ($data) {
                return $data->assigner_priority->immediate;
            })
            ->addColumn('visited', function ($data) {
                return (bool)$data->visited;
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
        $r = [];
        $range_start = gmdate("Y-m-d", $request->input('range_start'));
        $range_end = gmdate("Y-m-d", $request->input('range_end'));
        $filters['code'] = trim($request->input('calendar_filter_code'));
        $filters['subject'] = trim($request->input('calendar_filter_subject'));
        $filters['title'] = trim($request->input('calendar_filter_title', null));
        $filters['employee'] = trim($request->input('calendar_filter_employee', -1));
        $filters['status'] = trim($request->input('filter_status', -1));
        $filters['importance'] = trim($request->input('calendar_filter_importance', -1));
        $filters['immediate'] = trim($request->input('calendar_filter_immediate', -1));
        $no_filters =
            null == $filters['code'] &&
            null == $filters['title'] &&
            null == $filters['subject'] &&
            -1 == $filters['employee'] &&
            -1 == $filters['status'] &&
            -1 == $filters['importance'] &&
            -1 == $filters['immediate'];
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $my_assignments = $user->my_assigned_tasks_assignments();
        if ($no_filters)
        {
            $my_assignments = $my_assignments->with(['task.subject', 'employee', 'task.priority']);
        }
        else
        {
            if ($filters['title'])
            {
                $my_assignments = $my_assignments->whereHas('task', function ($q) use ($filters) {
                    $q->whereRaw('CONCAT(ltm_tasks.title, ltm_tasks.description) LIKE ?', ["%$filters[title]%"]);
                });
            }
            if ($filters['code'])
            {
                $my_assignments = $my_assignments->whereHas('task', function ($q) use ($filters) {
                    $q->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
                });
            }
            if ($filters['subject'])
            {
                $my_assignments = $my_assignments->with('task.subject')->whereHas('task.subject', function ($q) use ($filters) {
                    $q->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            }
            else
            {
                $my_assignments = $my_assignments->with('task.subject');
            }
            if (-1 != $filters['employee'])
            {
                $my_assignments = $my_assignments->where('employee_id', $filters['employee']);
            }
            else
            {
                $my_assignments = $my_assignments->with('employee');
            }
            if (-1 != $filters['importance'] && -1 != $filters['immediate'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.importance', $filters['importance'])
                        ->where('ltm_task_priorities.immediate', $filters['immediate'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            elseif (-1 != $filters['importance'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.importance', $filters['importance'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            elseif (-1 != $filters['immediate'])
            {
                $my_assignments = $my_assignments->with(['task.priority' => function ($q) use ($user) {
                    $q->where('ltm_task_priorities.user_id', $user->id);
                }])->whereHas('task.priority', function ($q) use ($filters, $user) {
                    $q->where('ltm_task_priorities.immediate', $filters['immediate'])
                        ->where('ltm_task_priorities.user_id', $user->id);
                });
            }
            else
            {
                $my_assignments = $my_assignments->with('priority');
            }
        }
        $my_tasks = $user->myassignedtasks->whereRaw('start_time >= ? AND start_time <= ?', ["$range_start 00:00:00", "$range_end 23:59:59"])->get();
        foreach ($my_tasks as $my_task)
        {
            $minutes_to_time = ltm_minutes_to_time($my_task->duration_timestamp);
            $end_datatime = new DateTime($my_task->start_time);
            $date_interval = new \DateInterval($minutes_to_time['strings']['interval']);
            $end = $end_datatime->add($date_interval)->format('Y-m-d H:i:00');
            $id = ltm_encode_ids([$my_task->id]);
            $r[] =
                [
                    'id'               => $id,
                    'title'            => $my_task->title,
                    'start'            => $my_task->start_time,
                    'end'              => $end,
                    'url'              => route('ltm.modals.common.tasks.my_assigned_tasks.view') . "?assignment_id=" . ltm_encode_ids([$my_task->assignment]) . "&t=2",
                    'background_color' => $my_task->subject->background_color,
                    'text_color'       => $my_task->subject->text_color,
                ];
        }

        return response()->json($r);
    }
}
