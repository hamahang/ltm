<?php

namespace Hamahang\LTM\Controllers\Modals\Common\Tasks;

use Hamahang\LTM\Controllers\Controller;
use Hamahang\LTM\Models\Form;
use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\Tasks\ClientChatHistory;
use Hamahang\LTM\Models\Tasks\Task;
use Hamahang\LTM\Models\Tasks\TaskAssignment;
use Hamahang\LVS\Models\Visit;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * MyTaskController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function add()
    {
        $LFM_options = ['size_file' => 1000, 'max_file_number' => 5, 'min_file_number' => 2, 'show_file_uploaded' => 'medium', 'true_file_extension' => ['jpg', 'jpeg', 'png', 'bmp', 'txt', 'xlsx', 'doc', 'docx', 'zip', 'rar'], 'path' => 'test'];
        $LFM = LFM_CreateModalFileManager('attachment', $LFM_options, 'insert', 'callback', null, null, null, 'انتخاب فایل/ها');
        $subjects = Subject::all();
        $header = view('laravel_task_manager::modals.tasks.task.add.header')->render();
        $content =  view('laravel_task_manager::modals.tasks.task.add.content')->with(compact('LFM', 'subjects'))->render();
        $footer = view('laravel_task_manager::modals.tasks.task.add.footer')->render();
        $r = json_encode(['header' => $header, 'content' => $content, 'footer' => $footer, ]);
        return $r;
    }

    /**
     * @param $transcripts
     * @return string
     */
    private function transcripts_datatable_data($transcripts)
    {
        $row = 1;
        $transcripts_data = [];
        if ($transcripts)
        {
            foreach ($transcripts as $transcript)
            {
                $user = $transcript->user;
                $transcripts_data[] =
                    [
                        'row' => $row,
                        'user_full_name' => $user->full_name,
                        'user_username' => $user->username,
                        'user_image' => "<img src='$user->image' style='border: gray solid 1px; height: 32px; padding: 2px; width: 32px; border-radius: 2px;' />",
                        'transcript' => $transcript->type_name,
                        'user_hashed_id' => ltm_encode_ids([$user->id]),
                    ];
                $row++;
            }
        }
        return ltm_array_to_string_array($transcripts_data);
    }

    /**
     * @param $task
     * @return string
     * @throws \Throwable
     */
    function progress($task)
    {
        $r = null;
        $template = null;
        $data =
        [
            'F' => null,
            'P' => null,
            'M' => null,
            'N' => null,
            'L' => null,
        ];
        $assignments = $task->assignments;
        $assignments_count = count($assignments);
        $first_assigner_id = $assignments->first()->assigner->id;
        /*
         * *******************************
         *                               *
         *              M                *
         *                               *
         * *******************************
         *                               *
         *          L - M                *
         *                               *
         *      L - N - M                *
         *                               *
         *    L --- N - M                *
         *                               *
         * *******************************
         *                               *
         *              M - F            *
         *                               *
         *              M - P - F        *
         *                               *
         *              M - P --- F      *
         *                               *
         * *******************************
         *                               *
         *          L - M - F            *
         *                               *
         *      L - N - M - F            *
         *                               *
         *    L --- N - M - F            *
         *                               *
         *          L - M - P - F        *
         *                               *
         *          L - M - P --- F      *
         *                               *
         * *******************************
         *                               *
         *      L - N - M - P - F        *
         *                               *
         *    L --- N - M - P - F        *
         *                               *
         *      L - N - M - P --- F      *
         *                               *
         *    L --- N - M - P --- F      *
         *                               *
         * *******************************
         */
        $data['M'] = auth()->user();
        switch (true)
        {
            // when 1 record
            case 1 == $assignments_count:
                $assignment = $assignments->first();
                switch (true)
                {
                    // me directly to myself. M
                    case $assignment->assigner->id == $assignment->employee->id:
                        $template = view('laravel_task_manager::modals.tasks.progress.M')->with(['data' => $data]);
                        break;
                    // me directly to last. L-M
                    case $assignment->assigner->id == auth()->id():
                        $data['L'] = $assignment->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-M')->with(['data' => $data]);
                        break;
                    // first directly to me. M-F
                    case $assignment->employee->id == auth()->id():
                        $data['F'] = $assignment->assigner;
                        $template = view('laravel_task_manager::modals.tasks.progress.M-F')->with(['data' => $data]);
                        break;
                }
                break;
            // when 2 records
            case 2 == $assignments_count:
                $assignment_F = $assignments->first();
                $assignment_L = $assignments->last();
                switch (true)
                {
                    // first directly to me, me directly to last. L-M-F
                    case $assignment_F->employee->id == auth()->id() && $assignment_L->assigner->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-M-F')->with(['data' => $data]);
                        break;
                    // me directly to next, next directly last. L-N-M
                    case $assignment_F->assigner->id == auth()->id():
                        $data['N'] = $assignment_F->employee;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-N-M')->with(['data' => $data]);
                        break;
                    // first directly to previous, previous directly to me. M-P-F
                    case $assignment_L->employee->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['P'] = $assignment_L->assigner;
                        $template = view('laravel_task_manager::modals.tasks.progress.M-P-F')->with(['data' => $data]);
                        break;
                }
                break;
            // when 3 records
            case 3 == $assignments_count:
                $assignment_F = $assignments->shift();
                $assignment_L = $assignments->pop();
                switch (true)
                {
                    // me directly to next, next indirectly to last
                    case $assignment_F->assigner->id == auth()->id():
                        $data['N'] = $assignment_F->employee;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L---N-M')->with(['data' => $data]);
                        break;
                    // first indirectly to previous, previous directly to me
                    case $assignment_L->employee->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['P'] = $assignment_L->assigner;
                        $template = view('laravel_task_manager::modals.tasks.progress.M-P---F')->with(['data' => $data]);
                        break;
                    // first directly to me, me directly to next, next directly to last. L-N-M-F
                    case $assignment_F->employee->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['N'] = $assignment_L->assigner;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-N-M-F')->with(['data' => $data]);
                        break;
                    // first directly to previous, previous directly to me, me directly to last
                    case $assignment_L->assigner->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['P'] = $assignment_F->employee;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-M-P-F')->with(['data' => $data]);
                        break;
                }
                break;
            // when more than 3 records
            case $assignments_count > 3:
                $assignment_F = $assignments->shift();
                $assignment_L = $assignments->pop();
                switch (true)
                {
                    // me directly to next, next indirectly to last. L---N-M
                    case $assignment_F->assigner->id == auth()->id():
                        $data['N'] = $assignment_F->employee;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L---N-M')->with(['data' => $data]);
                        break;
                    // first indirectly to previous, previous directly to me. M-P---F
                    case $assignment_L->employee->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $data['P'] = $assignment_L->assigner;
                        $template = view('laravel_task_manager::modals.tasks.progress.M-P---F')->with(['data' => $data]);
                        break;
                    // first directly to me, me directly to next, next directly to last. L-N-M-F
                    case $assignment_F->employee->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $assignment_N = $assignments->shift();
                        $data['N'] = $assignment_N->employee;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L---N-M-F')->with(['data' => $data]);
                        break;
                    // first directly to previous, previous directly to me, me directly to last
                    case $assignment_L->assigner->id == auth()->id():
                        $data['F'] = $assignment_F->assigner;
                        $assignment_P = $assignments->pop();
                        $data['P'] = $assignment_P->assigner;
                        $data['L'] = $assignment_L->employee;
                        $template = view('laravel_task_manager::modals.tasks.progress.L-M-P---F')->with(['data' => $data]);
                        break;
                    // L-N-M-P-F, L---N-M-P-F, L-N-M-P---F and L---N-M-P---F
                    default:
                        $assignment_P = null;
                        $assignment_N = null;
                        $indirect = ['FP' => false, 'NL' => false];
                        $count = 0;
                        foreach ($assignments as $assignment)
                        {
                            if ($assignment->employee->id == auth()->id())
                            {
                                $assignment_P = $assignment;
                                $count = 0;
                            } else
                            {
                                $count++;
                            }
                        }
                        $indirect['FP'] = abs($assignments->count() - $count) > 1 ? true : false;
                        $count = 0;
                        foreach ($assignments->reverse() as $assignment)
                        {
                            if ($assignment->assigner->id == auth()->id())
                            {
                                $assignment_N = $assignment;
                                break;
                            } else
                            {
                                $indirect['NL'] = true;
                                $count++;
                            }
                        }
                        $indirect['NL'] = $count >= 1 ? true : false;
                        $data['F'] = $assignment_F->assigner;
                        $data['P'] = $assignment_P->assigner;
                        $data['N'] = $assignment_N->employee;
                        $data['L'] = $assignment_L->employee;
                        switch (true)
                        {
                            // first directly to previous, previous directly to me, me directly to next, next directly to last. L-N-M-P-F
                            case !$indirect['FP'] && !$indirect['NL']:
                                $template = view('laravel_task_manager::modals.tasks.progress.L-N-M-P-F')->with(['data' => $data]);
                                break;
                            // first directly to previous, previous directly to me, me directly to next, next indirectly to last. L---N-M-P-F
                            case !$indirect['FP'] && $indirect['NL']:
                                $template = view('laravel_task_manager::modals.tasks.progress.L---N-M-P-F')->with(['data' => $data]);
                                break;
                            // first indirectly to previous, previous directly to me, me directly to next, next directly to last. L-N-M-P---F
                            case $indirect['FP'] && !$indirect['NL']:
                                $template = view('laravel_task_manager::modals.tasks.progress.L-N-M-P---F')->with(['data' => $data]);
                                break;
                            // first indirectly to previous, previous directly to me, me directly to next, next indirectly to last. L---N-M-P---F
                            case $indirect['FP'] && $indirect['NL']:
                                $template = view('laravel_task_manager::modals.tasks.progress.L---N-M-P---F')->with(['data' => $data]);
                                break;
                        }
                        break;
                }
                break;
        }
        $r['data'] = $data;
        $r['template'] = $template->render();
        $r['assigner'] = $data['P'] ? : $data['F'] ? : $data['M'];
        $r['employee'] = $data['N'] ? : $data['L'] ? : $data['M'];
        $r['is_creator'] = $first_assigner_id == auth()->id();
        return $r;
    }

    /**
     * @param $assignment_id
     * @return mixed
     */
    function progress_transcript($assignment_id)
    {
        $assignment = TaskAssignment::where('id', $assignment_id)->with('assigner', 'employee')->first();
        $data['P'] = $assignment->assigner;
        $data['M'] = auth()->user();
        $data['N'] = $assignment->employee;
        $r['data'] = $data;
        $r['template'] = view('laravel_task_manager::modals.tasks.progress.transcript.N-M-P')->with(['data' => $data]);
        $r['assigner'] = $data['P'];
        $r['employee'] = $data['N'];
        return $r;
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function view(Request $request)
    {
        $default_tab = 'details'; // details|transcripts|attachs|calendar|action|history
        $id = ltm_decode_ids($request->input('id'), 0);
        $t = $request->input('t');
        if ($t == '1')
        {
            $task = Task::with('subject', 'assignment.assigner', 'assignment.employee', 'priority', 'keywords', 'logs')->find($id);
            $assignment = $task->assignments()->where( [
                ['ltm_task_assignments.task_id', '=', $id],
                ['ltm_task_assignments.transmitter_id', '=', '0'],
                ['ltm_task_assignments.transferred_to_id', '=', '0'],
                ['ltm_task_assignments.integrated_task_id', '=', '0'],
                ['ltm_task_assignments.rejected_at', null, 'IS NULL'],
                ['ltm_task_assignments.is_active', '1'],
            ])->first();
            $assignment_id = $assignment->id ;
        }
        else
        {
            $assignment_id = ltm_decode_ids($request->input('assignment_id'), 0);
            $assignment = TaskAssignment::with('confirmation')->find($assignment_id);
            $task = Task::where('id',  $assignment->task_id)->with('subject', 'assignment.assigner', 'assignment.employee', 'priority', 'keywords', 'logs')->first();
        }

        $is_final_assigment = false ;
        $final_assigment = $task->assignments()->orderBY('id','desc')->first();
        if (isset($final_assigment) && isset($final_assigment->employee_id) && $final_assigment->employee_id  == auth()->id())
        {
            $is_final_assigment = true ;
        }
        $chats = ClientChatHistory::with('user')->where('assignment_id',$assignment_id)->get() ;
        $LFM = LFM_ShowMultiFile($task);
        if (isset($LFM['data'])) { $LFM_show = empty($LFM['data']) ? '<div class="well">موردی برای نمایش وجود ندارد.</div>' : $LFM['view']['grid']; }
        $common_with = ['default_tab' => $default_tab, 'task' => $task, 'assignment' => $assignment, ];
        $action_do_form_fields = Form::generate_fields($task->assignment->action_do_form_id, $task->assignment->action_do_fields_code);
        $action_transfer_form_fields = Form::generate_fields($task->assignment->action_transfer_form_id, $task->assignment->action_transfer_fields_code);
        $action_reject_form_fields = Form::generate_fields($task->assignment->action_reject_form_id, $task->assignment->action_reject_fields_code);
        if (3 == $t)
        {
            $common_with['progress'] = $this->progress_transcript($assignment_id);
            $transcripts = $assignment->transcripts_cc;
            $header_with = [];
            $content_with =
            [
                'action_do_form_fields' => $action_do_form_fields,
                'action_transfer_form_fields' => $action_transfer_form_fields,
                'action_reject_form_fields' => $action_reject_form_fields,
                'transcripts_data' => $transcripts,
                'chats' => $chats,
                'user_id' => auth()->id(),
                'is_final_assigment' => $is_final_assigment,
                'LFM' => $LFM,
                'LFM_show' => $LFM_show,
            ];
            $footer_with = ['transcripts_datatable_data' => $this->transcripts_datatable_data($transcripts),];
            $header = view('laravel_task_manager::modals.tasks.my_transcript_tasks.view.header')->with(array_merge($common_with, $header_with))->render();
            $content = view('laravel_task_manager::modals.tasks.my_transcript_tasks.view.content')->with(array_merge($common_with, $content_with))->render();
            $footer = view('laravel_task_manager::modals.tasks.my_transcript_tasks.view.footer')->with(array_merge($common_with, $footer_with))->render();
            $visit_target_type = 'Hamahang\LTM\Models\Tasks\TaskTranscript';
            $visit_target_id = $assignment->id;
        } else
        {
            $progress = $this->progress($task);
            $LFM_options = ['size_file' => 10000, 'max_file_number' => 1, 'true_file_extension' => ['zip', 'rar']];
            $lfm_track = LFM_CreateModalFileManager('attachment_track', $LFM_options, 'insert', 'callback_track', null, null, null, 'انتخاب فایل/ها');
            $assigner_progress_id = $progress['assigner']->id ;
            $track_view = view('laravel_task_manager::modals.tasks.my_tasks.view.track')
                ->with('chats',$chats)
                ->with('lfm_track',$lfm_track)
                ->with('is_final_assigment',$is_final_assigment)
                ->with('assignment_id' , ltm_encode_ids([$assignment_id]))
                ->render();
            switch (true)
            {
                case ($progress['employee']->id == auth()->id()) || $assigner_progress_id == auth()->id():
                    $common_with['progress'] = $progress;
                    $transcripts = @$assignment->transcripts_cc;
                    $header_with = [];
                    $content_with =
                    [
                        'action_do_form_fields' => $action_do_form_fields,
                        'action_transfer_form_fields' => $action_transfer_form_fields,
                        'action_reject_form_fields' => $action_reject_form_fields,
                        'transcripts_data' => $transcripts,
                        'is_final_assigment' => $is_final_assigment,
                        'assignment_id' => ltm_encode_ids([$assignment_id]),
                        'track_view' => $track_view,
                        'user_id' => auth()->id(),
                        'LFM' => $LFM, 'LFM_show' => $LFM_show,
                    ];
                    $footer_with = ['transcripts_datatable_data' => $this->transcripts_datatable_data($transcripts), ];
                    $header = view('laravel_task_manager::modals.tasks.my_tasks.view.header')->with(array_merge($common_with, $header_with))->render();
                    $content = view('laravel_task_manager::modals.tasks.my_tasks.view.content')->with(array_merge($common_with, $content_with))->render();
                    $footer = view('laravel_task_manager::modals.tasks.my_tasks.view.footer')->with(array_merge($common_with, $footer_with))->render();
                    break;
                case $progress['assigner']->id == auth()->id() && $progress['employee']->id == auth()->id() || $progress['assigner']->id == auth()->id():
                default:
                    $common_with['progress'] = $progress;
                    $transcripts = $assignment->transcripts;
                    $header_with = [];
                    $content_with =
                    [
                        'action_do_form_fields' => $action_do_form_fields,
                        'action_transfer_form_fields' => $action_transfer_form_fields,
                        'action_reject_form_fields' => $action_reject_form_fields,
                        'transcripts_data' => $transcripts,
                        'is_final_assigment' => $is_final_assigment,
                        'assignment_id' => ltm_encode_ids([$assignment_id]),
                        'track_view' => $track_view,
                        'chats' => $chats,
                        'user_id' => auth()->id(),
                        'LFM' => $LFM, 'LFM_show' => $LFM_show,
                    ];
                    $footer_with = ['transcripts_datatable_data' => $this->transcripts_datatable_data($transcripts), ];
                    $header = view('laravel_task_manager::modals.tasks.my_assigned_tasks.view.header')->with(array_merge($common_with, $header_with))->render();
                    $content = view('laravel_task_manager::modals.tasks.my_assigned_tasks.view.content')->with(array_merge($common_with, $content_with))->render();
                    $footer = view('laravel_task_manager::modals.tasks.my_assigned_tasks.view.footer')->with(array_merge($common_with, $footer_with))->render();
                    break;
            }
            $visit_target_type = 'Hamahang\LTM\Models\Tasks\TaskAssignment';
            $visit_target_id = $assignment->id;
        }
        $visit = new Visit;
        $visit->target_type = $visit_target_type;
        $visit->target_id = $visit_target_id;
        $visit->user_id = auth()->id();
        $visit->ip = \Request::ip();
        $visit->created_by = auth()->id();
        $visit->save();
        $r = json_encode(['header' => $header, 'content' => $content, 'footer' => $footer, ]);
//        dd($task->assignments->toArray());
        return $r;
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function integrate(Request $request)
    {
        $hashed_ids_array = $request->input('hashed_ids_array');
        $hashed_ids_array_items = explode(',', $hashed_ids_array);
        foreach ($hashed_ids_array_items as $hashed_ids_array_item)
        {
            $ids[] = ltm_decode_ids($hashed_ids_array_item, 0);
        }
        $tasks = Task::whereIn('id', $ids)->with('subject')->with('assignment.assigner')->with('priority')->with('keywords')->get();
        $row = 1;
        foreach ($tasks as $task)
        {
            $choices[] =
            [
                'row' => $row,
                'code' => $task->code,
                'subject' => $task->subject->title,
                'title' => $task->title,
                'assigner' => $task->assignment->assigner->full_name,
                'importance' => $task->priority->first()->importance_name,
                'immediate' => $task->priority->first()->immediate_name,
                //'operations' => '<i class="fa fa-times pointer" style="color: red;" onclick="$(this).parent().parent().remove();"></i>',
                'hashed_id' => ltm_encode_ids([$task->id]),
            ];
            $row++;
        }
        $choices_datatable_data = ltm_array_to_string_array($choices);
        $hashed_ids = ltm_encode_ids($ids);
        $LFM_options =
        [
            'size_file' => 1000,
            'max_file_number' => 5,
            'min_file_number' => 2,
            'show_file_uploaded' => 'medium',
            'true_file_extension' => ['png', 'jpg', 'jpeg', 'bmp', 'zip', 'rar', 'docx', 'xlsx'],
            'path' => 'test'
        ];
        $LFM = LFM_CreateModalFileManager('attachment', $LFM_options, 'insert', 'callback', null, null, null, 'انتخاب فایل/ها');
        $content_with =
        [
            'hashed_ids' => $hashed_ids,
            'LFM' => $LFM,
        ];
        $footer_with =
        [
            'choices_datatable_data' => $choices_datatable_data,
        ];
        $header = view('laravel_task_manager::modals.tasks.task.integrate.header')->render();
        $content = view('laravel_task_manager::modals.tasks.task.integrate.content')->with($content_with)->render();
        $footer = view('laravel_task_manager::modals.tasks.task.integrate.footer')->with($footer_with)->render();
        $r = json_encode(['header' => $header, 'content' => $content, 'footer' => $footer,]);
        return $r;
    }
}
