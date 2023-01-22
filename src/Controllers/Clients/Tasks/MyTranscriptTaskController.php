<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks;

use Hamahang\LTM\Controllers\Controller;
use Hamahang\LTM\Models\Tasks\TaskTranscript;
use DataTables;
use DateTime;
use Illuminate\Http\Request;

class MyTranscriptTaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return $this
     */
    public function index()
    {
        $assigners_and_employees = config('laravel_task_manager.user_model')::find(auth()->id())->my_transcript_tasks_assigners_and_employees_for_select2;
        $assigners_and_employees_trash = config('laravel_task_manager.user_model')::find(auth()->id())->my_transcript_tasks_trash_assigners_and_employees_for_select2;
        $with =
        [
            'assigners' => $assigners_and_employees['assigners'],
            'employees' => $assigners_and_employees['employees'],
            'assigners_trash' => $assigners_and_employees_trash['assigners'],
            'employees_trash' => $assigners_and_employees_trash['employees'],
        ];
        return view('laravel_task_manager::clients.tasks.my_transcript_tasks.index')->with($with);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function datatable_get(Request $request)
    {
        $filters['code'] = trim($request->input('filter_code', null));
        $filters['subject'] = trim($request->input('filter_subject'));
        $filters['title'] = trim($request->input('filter_title', null));
        $filters['assigner'] = $request->input('filter_assigner', -1);
        $filters['employee'] = $request->input('filter_employee', -1);
        $filters['status'] = $request->input('filter_status', -1);
        $filters['importance'] = $request->input('filter_importance', -1);
        $filters['immediate'] = $request->input('filter_immediate', -1);
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $no_filters =
            null == $filters['code'] &&
            null == $filters['subject'] &&
            null == $filters['title'] &&
            -1 == $filters['assigner'] &&
            -1 == $filters['employee'] &&
            -1 == $filters['status'] &&
            -1 == $filters['importance'] &&
            -1 == $filters['immediate'];
        if ($no_filters)
        {
            $my_transcript_assignments = $user->my_transcript_assignments()->with('task.subject', 'task.priority');
        } else
        {
            if ($filters['title'])
            {
                $my_transcript_assignments = $user->my_transcript_assignments()->whereRaw('CONCAT(ltm_tasks.title, ltm_tasks.description) LIKE ?', ["%$filters[title]%"]);
            } else
            {
                $my_transcript_assignments = $user->my_transcript_assignments();
            }
            if ($filters['code'])
            {
                $my_transcript_assignments = $user->my_transcript_assignments()->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
            }
            if ($filters['subject'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('task.subject')->whereHas('subject', function($query) use ($filters)
                {
                    $query->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('task.subject');
            }
            if (-1 != $filters['assigner'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('assigner')->whereHas('assigner', function($query) use ($filters)
                {
                    $query->where('ltm_task_assignments.assigner_id', $filters['assigner']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('assigner');
            }
            if (-1 != $filters['employee'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('employee')->whereHas('employee', function($query) use ($filters)
                {
                    $query->where('ltm_task_assignments.employee_id', $filters['employee']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('employee');
            }
            if (-1 != $filters['status'])
            {
                //adel.raheli
                $my_transcript_assignments = $my_transcript_assignments->whereHas('task.assignments.statuses', function($query) use ($filters)
                {
                    $query->whereRaw('(SELECT MAX(status) FROM ltm_task_statuses AS task_statuses WHERE task_statuses.status = ?)', [$filters['status']]);
                });
            }
            if (-1 != $filters['importance'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.importance', $filters['importance']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('task.priority');
            }
            if (-1 != $filters['immediate'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('task.priority')->whereHas('task.priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.immediate', $filters['immediate']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('task.priority');
            }
        }
        //dd($my_transcript_assignments->get()->toArray());
        $r = Datatables::eloquent($my_transcript_assignments)
            /*
            ->editColumn('id', function($data)
            {
                return ltm_encode_ids([$data->id]);
            })
            */
            ->addColumn('subject', function($data)
            {
                return $data->task->subject->title;
            })
            ->editColumn('title', function($data)
            {
                $route = route('ltm.modals.common.tasks.my_transcript_tasks.view');
                $data_reload = true ? 'reload' : null;
                $data_href = "$route?assignment_id={$data->encoded_id}&t=3";
                $data_title = 'مشاهده جزئیات' . ' ' . $data->task->title;
                $title = $data->task->title . ($data->description ? " ({$data->description})" : null);
                $r = "<a class='jsPanels' data-reload='$data_reload' data-href='$data_href' data-title='$data_title'>$title</a>";
                return $r;
            })
            ->addColumn('assigner', function($data)
            {
                return $data->assigner->full_name;
            })
            ->addColumn('employee', function($data)
            {
                return $data->employee->full_name;
            })
            ->addColumn('status', function($data)
            {
                $current_status = $data->current_status;
                $percent = ' (' . $current_status->percent . '%)';
                return $current_status->status_name . (1 == $current_status->status ? $percent : null);
            })
            ->addColumn('importance', function($data)
            {
                return $data->assigner_priority->importance;
            })
            ->addColumn('immediate', function($data)
            {
                return $data->assigner_priority->immediate;
            })
            ->addColumn('deletion_args', function($data)
            {
                return ltm_encode_ids([auth()->id(), $data->id, ]);
            })
            ->addColumn('visited', function($data)
            {
                return (bool) $data->transcript->visited;
            })
            ->rawColumns(['title'])
            ->make(true);
        return $r;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function datatable_get_trash(Request $request)
    {
        $filters['code_trash'] = trim($request->input('filter_code_trash'));
        $filters['subject_trash'] = trim($request->input('filter_subject_trash'));
        $filters['title_trash'] = trim($request->input('filter_title_trash', null));
        $filters['assigner_trash'] = trim($request->input('filter_assigner_trash', -1));
        $filters['employee_trash'] = trim($request->input('filter_employee_trash', -1));
        $filters['status_trash'] = trim($request->input('filter_status_trash', -1));
        $filters['importance_trash'] = trim($request->input('filter_importance_trash', -1));
        $filters['immediate_trash'] = trim($request->input('filter_immediate_trash', -1));
        $user = config('laravel_task_manager.user_model')::find(auth()->id());
        $no_filters =
            null == $filters['code_trash'] &&
            null == $filters['subject_trash'] &&
            null == $filters['title_trash'] &&
            -1 == $filters['assigner_trash'] &&
            -1 == $filters['employee_trash'] &&
            -1 == $filters['status_trash'] &&
            -1 == $filters['importance_trash'] &&
            -1 == $filters['immediate_trash'];
        if ($no_filters)
        {
            $my_transcript_assignments_trash = $user->my_transcript_assignments_trash()->with('task.subject', 'task.priority');
        } else
        {
            if ($filters['title_trash'])
            {
                $my_transcript_assignments_trash = $user->my_transcript_assignments_trash()->whereRaw('CONCAT(ltm_tasks.title, ltm_tasks.description) LIKE ?', ["%$filters[title_trash]%"]);
            } else
            {
                $my_transcript_assignments_trash = $user->my_transcript_assignments_trash();
            }
            if ($filters['code_trash'])
            {
                $my_transcript_assignments_trash = $user->my_transcript_assignments_trash()->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code_trash]%"]);
            }
            if ($filters['subject_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('subject')->whereHas('subject', function($query) use ($filters)
                {
                    $query->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject_trash]%"]);
                });
            } else
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('subject');
            }
            if (-1 != $filters['assigner_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('assignment.assigner')->whereHas('assignment', function($query) use ($filters)
                {
                    $query->whereHas('assigner', function($query) use ($filters)
                    {
                        $query->where('ltm_task_assignments.assigner_id', $filters['assigner_trash']);
                    });
                });
            } else
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('assignment.assigner');
            }
            if (-1 != $filters['employee_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('assignment.employee')->whereHas('assignment', function($query) use ($filters)
                {
                    $query->whereHas('employee', function($query) use ($filters)
                    {
                        $query->where('ltm_task_assignments.employee_id', $filters['employee_trash']);
                    });
                });
            } else
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('assignment.employee');
            }
            if (-1 != $filters['status_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->whereHas('statuses', function($query) use ($filters)
                {
                    $query->whereRaw('(SELECT MAX(status) FROM ltm_task_statuses AS task_statuses WHERE task_statuses.status = ?)', [$filters['status_trash']]);
                });
            }
            if (-1 != $filters['importance_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.importance', $filters['importance_trash']);
                });
            } else
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('priority');
            }
            if (-1 != $filters['immediate_trash'])
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.immediate', $filters['immediate_trash']);
                });
            } else
            {
                $my_transcript_assignments_trash = $my_transcript_assignments_trash->with('priority');
            }
        }
        $r = Datatables::eloquent($my_transcript_assignments_trash)
            /*
            ->editColumn('id', function($data)
            {
                return ltm_encode_ids([$data->id]);
            })
            */
            ->addColumn('subject_trash', function($data)
            {
                return $data->task->subject->title;
            })
            ->editColumn('title_trash', function($data)
            {
                $route = route('ltm.modals.common.tasks.my_transcript_tasks.view');
                $data_reload = true ? 'reload' : null;
                $data_href = "$route?assignment_id={$data->encoded_id}&t=3";
                $data_title = 'مشاهده جزئیات' . ' ' . $data->task->title;
                $title = $data->task->title . ($data->description ? " ({$data->description})" : null);
                $r = "<a class='jsPanels' data-reload='$data_reload' data-href='$data_href' data-title='$data_title'>$title</a>";
                return $r;
            })
            ->addColumn('assigner_trash', function($data)
            {
                return $data->assigner->full_name;
            })
            ->addColumn('employee_trash', function($data)
            {
                return $data->employee->full_name;
            })
            ->addColumn('status_trash', function($data)
            {
                if ($data->transcript->statuses)
                {
                    $percent = ' (' . $data->transcript->statuses->first()->percent . '%)';
                    return $data->transcript->statuses->first()->status_name . (1 == $data->transcript->statuses->first()->status ? $percent : null);
                }
                else
                {
                    return '' ;
                }

            })
            ->addColumn('importance_trash', function($data)
            {
                return $data->assigner_priority->importance;
            })
            ->addColumn('immediate_trash', function($data)
            {
                return $data->assigner_priority->immediate;
            })
            ->addColumn('deletion_args', function($data)
            {
                return ltm_encode_ids([auth()->id(), $data->id, ]);
            })
            ->addColumn('visited_trash', function($data)
            {
                return (bool) $data->transcript->visited;
            })
            ->rawColumns(['title_trash'])
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
            $my_transcript_assignments = $user->my_transcript_assignments()->with('task.subject', 'task.priority');
        } else
        {
            if ($filters['title'])
            {
                $my_transcript_assignments = $user->my_transcript_assignments_trash->whereRaw('CONCAT(ltm_tasks.title, IFNULL(ltm_tasks.description, "")) LIKE ?', ["%$filters[title]%"]);
            } else
            {
                $my_transcript_assignments = $user->my_tasks;
            }
            if ($filters['code'])
            {
                $my_transcript_assignments = $user->my_tasks->whereRaw('ltm_tasks.code LIKE ?', ["%$filters[code]%"]);
            }
            if ($filters['subject'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('subject')->whereHas('subject', function($query) use ($filters)
                {
                    $query->whereRaw('ltm_subjects.title LIKE ?', ["%$filters[subject]%"]);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('subject');
            }
            if (-1 != $filters['assigner'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('assignment.assigner')->whereHas('assignment', function($query) use ($filters)
                {
                    $query->whereHas('assigner', function($query) use ($filters)
                    {
                        $query->where('ltm_task_assignments.assigner_id', $filters['assigner']);
                    });
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('assignment.assigner');
            }
            if (-1 != $filters['importance'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.importance', $filters['importance']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('priority');
            }
            if (-1 != $filters['immediate'])
            {
                $my_transcript_assignments = $my_transcript_assignments->with('priority')->whereHas('priority', function($query) use ($filters)
                {
                    $query->where('ltm_task_priorities.immediate', $filters['immediate']);
                });
            } else
            {
                $my_transcript_assignments = $my_transcript_assignments->with('priority');
            }
        }
        $my_transcript_assignments = $my_transcript_assignments->whereRaw('ltm_task_transcripts.created_at >= ? AND ltm_task_transcripts.created_at <= ?', ["$range_start 00:00:00", "$range_end 23:59:59"])->get();
        foreach ($my_transcript_assignments as $assignment)
        {
            $minutes_to_time = ltm_minutes_to_time($assignment->task->duration_timestamp);
            $end_datatime = new DateTime($assignment->task->start_time);
            $date_interval = new \DateInterval($minutes_to_time['strings']['interval']);
            $end = $end_datatime->add($date_interval)->format('Y-m-d H:i:00');
            $id = ltm_encode_ids([$assignment->task->id]);
            $assignment->task_id = ltm_encode_ids([$assignment->task->id]);
            $r[] =
            [
                'id' => $id,
                'title' => $assignment->task->title,
                'start' => $assignment->task->start_time,
                'end' => $end,
                'url' => route('ltm.modals.common.tasks.my_transcript_tasks.view') . "?assignment_id=$assignment->task_id&t=3",
                'background_color' => $assignment->task->subject->background_color,
                'text_color' => $assignment->task->subject->text_color,
            ];
        }
        return response()->json($r);
    }

    /**
     * @param Request $request
     */
    public function trash(Request $request)
    {
        $hashed_ids = $request->input('hashed_ids', []);
        foreach ($hashed_ids as $hashed_id)
        {
            $where = ltm_decode_ids($hashed_id);
            $transcript = TaskTranscript::where('user_id', $where[0])->where('task_assignment_id', $where[1]);
            $transcript->update(['trashed_at' => date('Y-m-d H:i:s')]);
        }
    }

    /**
     * @param Request $request
     */
    public function restore(Request $request)
    {
        $hashed_ids = $request->input('hashed_ids', []);
        foreach ($hashed_ids as $hashed_id)
        {
            $where = ltm_decode_ids($hashed_id);
            $transcript = TaskTranscript::where('user_id', $where[0])->where('task_assignment_id', $where[1]);
            $transcript->update(['trashed_at' => null]);
        }
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $hashed_ids = $request->input('hashed_ids', []);
        foreach ($hashed_ids as $hashed_id)
        {
            $where = ltm_decode_ids($hashed_id);
            $transcript = TaskTranscript::where('user_id', $where[0])->where('task_assignment_id', $where[1]);
            $transcript->delete();
        }
    }
}
