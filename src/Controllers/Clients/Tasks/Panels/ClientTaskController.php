<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks\Panels;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMSArianaSMSPanel;
use App\Jobs\SendSMSMagfaSingleSMS;
use App\Mail\NewTaskNotify;
use DataTables;
use DB;
use Hamahang\LTM\Controllers\KeywordController;
use Hamahang\LTM\Models\Form;
use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\Tasks\ClientChatHistory;
use Hamahang\LTM\Models\Tasks\Task;
use Hamahang\LTM\Models\Tasks\TaskAssignment;
use Hamahang\LTM\Models\Tasks\TaskPriority;
use Hamahang\LTM\Models\Tasks\TaskStatus;
use Hamahang\LTM\Models\Tasks\TaskTranscript;
use Hamahang\LTM\Requests\Clients\Tasks\Panel\Add_Request;
use Hamahang\LTM\Requests\Clients\Tasks\Panel\Client_Response_Request;
use Illuminate\Http\Request;
use Mail;

/**
 *
 */
class ClientTaskController extends Controller
{
    /**
     * @param $employee_id
     * @param $code
     * @return void
     */
    private function send_notification_to_employe($employee_id, $code): void
    {

        $user = config('laravel_task_manager.user_model')::find($employee_id);
        $setting = $user->ltm_setting;
        if ($setting) {
            if ($setting->recive_sms_is_active == '1' && config('laravel_task_manager.send_sms_after_task_create_from_client')) {
                $text = 'برای شما یک وظیفه جدید با شناسه ' . $code . ' در سامانه سیفام ایجاد شده است .';
                if (config('magfa_sms.send_from') == 'magfa') {
                    //dispatch((new SendSMSMagfaSingleSMS($text, $user->mobile))->onQueue('high'));
                } else {
                    //dispatch((new SendSMSArianaSMSPanel($text, $user->mobile))->onQueue('high'));
                }

            }
            if ($setting->recive_email_is_active == '1' && config('laravel_task_manager.send_email_after_task_create_from_client')) {
                $info =
                    [
                        'code' => $code,
                        'full_name' => $user->full_name,
                        'email' => $user->email
                    ];
                Mail::to($user->email)->queue((new NewTaskNotify($info))->onQueue('high'));
            }
        } else {
            if (config('laravel_task_manager.send_sms_after_task_create_from_client')) {
                $text = 'برای شما یک وظیفه جدید با شناسه ' . $code . ' در سامانه سیفام ایجاد شده است .';
                if (config('magfa_sms.send_from') == 'magfa') {
                    //dispatch((new SendSMSMagfaSingleSMS($text, $user->mobile))->onQueue('high'));
                } else {
                    //dispatch((new SendSMSArianaSMSPanel($text, $user->mobile))->onQueue('high'));
                }
            }
            if (config('laravel_task_manager.send_email_after_task_create_from_client')) {
                $info =
                    [
                        'code' => $code,
                        'full_name' => $user->full_name,
                        'email' => $user->email
                    ];
                Mail::to($user->email)->queue((new NewTaskNotify($info))->onQueue('high'));
            }
        }

    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function JsPanelTask(Request $request)
    {
        $LFM_options = ['size_file' => 4 * 1000 * 1000, 'max_file_number' => 3, 'min_file_number' => 1, 'show_file_uploaded' => 'small', 'true_file_extension' => ['jpg', 'jpeg', 'png', 'bmp', 'txt', 'xlsx', 'doc', 'docx', 'zip', 'rar'], 'path' => 'task/uploaded'];
        $file = LFM_CreateModalUpload('attachment', 'showUploadFile', $LFM_options, 'result', 'UploadFileManager', false, 'show_result_button', 'آپلود فایل')['json'];
        $old_file = [];
        $step = config('laravel_task_manager.task_get_step_function_name')($request->step_id);
        $user_id = config('laravel_task_manager.task_get_user_id')();
        $user_requestes = config('laravel_task_manager.task_file_no_list_in_clients_function_name')($user_id);
        $all_request_filter = get_file_no_list_in_client_for_filter($user_id);
        $subjects = Subject::where('is_active', '1')->select('id', 'title as text')->get();
        return json_encode([
            'header' => 'درخواست پشتیبانی',
            'content' => view('laravel_task_manager::clients.tasks.panels.jspanel.content')
                ->with('request_id', $request->request_id)
                ->with('user_requestes', $user_requestes)
                ->with('all_request_filter', $all_request_filter)
                ->with('step', $step)
                ->with('type', 'insert')
                ->with('variable', $request->panelVariableName)
                ->with('file', $file)
                ->with('old_file', json_encode($old_file))
                ->with('variable', $request->panelVariableName)
                ->render(),
            'footer' => view('laravel_task_manager::clients.tasks.panels.jspanel.footer')
                ->with('type', 'insert')
                ->with('variable', $request->panelVariableName)
                ->with('user_requestes', $user_requestes)
                ->with('all_request_filter', $all_request_filter)
                ->with('step', $step)
                ->with('type', 'insert')
                ->with('variable', $request->panelVariableName)
                ->with('request_id', $request->request_id)
                ->with('file', $file)
                ->with('old_file', json_encode($old_file))
                ->render(),
            'inline_js' => remove_script_tags_for_eval(view('laravel_task_manager::clients.tasks.panels.jspanel.inline_js')
                ->with('variable', $request->panelVariableName)
                ->with('user_requestes', $user_requestes)
                ->with('type', 'insert')
                ->with('all_request_filter', $all_request_filter)
                ->with('step', $step)
                ->with('type', 'insert')
                ->with('variable', $request->panelVariableName)
                ->with('request_id', $request->request_id)
                ->with('file', $file)
                ->with('old_file', json_encode($old_file))
                ->with('subjects', $subjects)
                ->render())
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDatatable(Request $request)
    {
        $user_id = config('laravel_task_manager.task_get_user_id')();
        $user = config('laravel_task_manager.user_model')::find($user_id);
        $my_assignments = $user->my_assigned_tasks_assignments();
        $my_assignments->select('id', 'task_id', 'assigner_id', 'created_at');
        $my_assignments = $my_assignments->with(['task.subject', 'employee', 'task.priority'])->select('ltm_task_assignments.*');
        if ($request->filter_file_no) {
            $my_assignments = $my_assignments->whereHas('task', function ($q) use ($request) {
                $q->where('file_no', $request->filter_file_no);
            });
        }
        if ($request->filter_step_id) {
            $my_assignments = $my_assignments->whereHas('task', function ($q) use ($request) {
                $q->where('step_id', $request->filter_step_id);
            });
        }
        $r = Datatables::eloquent($my_assignments)
            ->editColumn('id', function ($data) use ($my_assignments) {
                return ltm_encode_ids([$data->id]);
            })
            ->addColumn('file_no', function ($data) {
                return @$data->task->file_no;
            })
            ->addColumn('step_name', function ($data) {
                return @$data->task->step_name;
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
            ->addColumn('employee', function ($data) {
                return $data->employee->full_name;
            })
            ->addColumn('status', function ($data) {
                $percent = ' (' . (isset($data->statuses->first()->percent) ? $data->statuses->first()->percent : 0) . '%)';

                if (isset($data->statuses->first()->status_name)) {
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
     * @param Add_Request $request
     * @return array
     */
    public function addTask(Add_Request $request)
    {
        DB::beginTransaction();
        try {
            // initialize variables for general
            $general_type = 1;
            $general_importance = $request->input('general_importance', false);
            $general_immediate = $request->input('general_immediate', false);
            $general_title = $request->input('general_title');
            $general_subject_id = $request->input('general_subject_id');
            $general_description = $request->input('general_description', null);
            $general_users_id = config('laravel_task_manager.task_assigments_default_users_id_function_name')();
            $general_keywords = KeywordController::make($request->input('general_keywords', []));
            $general_deadline = $request->input('general_deadline');
            $general_step_id = $request->input('general_step_id');
            $step_id = $request->input('step_id');
            $request_id = $request->input('request_id');
            $file_no = $request->input('file_no');
            // initialize variables for setting
            $setting_action_do_form_id = $request->input('setting_action_do_form_id');
            $setting_action_transfer_form_id = $request->input('setting_action_transfer_form_id');
            $setting_action_reject_form_id = $request->input('setting_action_reject_form_id');
            $setting_email = $request->input('setting_email');
            $setting_email_is_active = in_array('is_active', $setting_email ? $setting_email : []);
            $setting_email_users = $setting_email_is_active && in_array('users', $setting_email ? $setting_email : []);
            $setting_email_transcripts = $setting_email_is_active && in_array('transcripts', $setting_email ? $setting_email : []);
            $setting_sms = $request->input('setting_sms');
            $setting_sms_is_active = in_array('is_active', $setting_sms ? $setting_sms : []);
            $setting_sms_users = $setting_sms_is_active && in_array('users', $setting_sms ? $setting_sms : []);
            $setting_sms_transcripts = $setting_sms_is_active && in_array('transcripts', $setting_sms ? $setting_sms : []);
            $setting_messaging = $request->input('setting_messaging');
            $setting_messaging_is_active = in_array('is_active', $setting_messaging ? $setting_messaging : []);
            $setting_messaging_users = $setting_messaging_is_active && in_array('users', $setting_messaging ? $setting_messaging : []);
            $setting_messaging_transcripts = $setting_messaging_is_active && in_array('transcripts', $setting_messaging ? $setting_messaging : []);
            $setting_transferable = (string)(int)(bool)$request->input('setting_transferable', '0');
            $setting_end_on_assigner_accept = (string)(int)(bool)$request->input('setting_end_on_assigner_accept', '0');
            $setting_rejectable = (string)(int)(bool)$request->input('setting_rejectable', '0');
            if (!check_subject_task_permission($general_subject_id)) {
                $res =
                    [
                        'success' => false,
                        'message' =>
                            [
                                [
                                    'title' => 'لطفاً موارد زیر را بررسی نمایید',
                                    'items' => [0 => 'موضوع معتبر نمی باشد .'],
                                ],
                            ],
                    ];
                DB::commit();

                return $res;
            }
            // insert
            $user_id = config('laravel_task_manager.task_get_user_id')();
            foreach ($general_users_id as $employee_id) {
                // task
                $description_values_transcripts = [];
                $start_datetime = date('Y-m-d H:i:00');
                $duration_integer = 0;
                $task = new Task();
                $task->title = $general_title;
                $task->subject_id = $general_subject_id;
                $task->description = $general_description;
                $task->type = $general_type;
                if ($step_id) {
                    $task->step_id = $step_id;
                } else {
                    $task->step_id = $general_step_id;
                }
                if ($file_no) {
                    $task->file_no = $file_no;
                } else {
                    $task->file_no = $request_id;
                }
                $task->start_time = $start_datetime;
                $task->duration_timestamp = $duration_integer;
                $task->schedule_id = 0;
                $task->template_id = 0;
                $task->is_active = '1';
                $task->created_by = $user_id;
                $task->started_by = $user_id;
                $task->code = microtime();
                $task->save();
                $task->code = ltm_make_task_code(Subject::find($general_subject_id)->code, $task->id);
                $task->save();
                // assignment
                $task_assignment = new TaskAssignment();
                $task_assignment->task_id = $task->id;
                $task_assignment->employee_id = $employee_id;
                $task_assignment->assigner_id = $user_id;
                $task_assignment->transferred_to_id = 0;
                $task_assignment->transmitter_id = 0;
                $task_assignment->integrated_task_id = 0;
                $task_assignment->rejected_at = null;
                $task_assignment->action_do_form_id = $setting_action_do_form_id;
                if ($setting_action_do_form_id) {
                    $task_assignment->action_do_fields_code = Form::generate_fields_code($setting_action_do_form_id);
                }
                $task_assignment->action_transfer_form_id = $setting_action_transfer_form_id;
                if ($setting_action_transfer_form_id) {
                    $task_assignment->action_transfer_fields_code = Form::generate_fields_code($setting_action_transfer_form_id);
                }
                $task_assignment->action_reject_form_id = $setting_action_reject_form_id;
                if ($setting_action_reject_form_id) {
                    $task_assignment->action_reject_fields_code = Form::generate_fields_code($setting_action_reject_form_id);
                }
                $task_assignment->transferable = '1';
                $task_assignment->end_on_assigner_accept = $setting_end_on_assigner_accept;
                $task_assignment->rejectable = $setting_rejectable;
                $task_assignment->created_by = $user_id;
                $task_assignment->save();
                // status
                $task_status = new TaskStatus();
                $task_status->task_assignment_id = $task_assignment->id;
                $task_status->type = TaskStatus::TYPE_ASSIGNER;
                $task_status->status = 0;
                $task_status->percent = 0;
                $task_status->created_by = $user_id;
                $task_status->save();
                // priority
                foreach ([$user_id, $employee_id] as $task_auth_and_employee_id) {
                    $task_priority = new TaskPriority();
                    $task_priority->task_id = $task->id;
                    $task_priority->user_id = $task_auth_and_employee_id;
                    $task_priority->importance = $general_importance;
                    $task_priority->immediate = $general_immediate;
                    $task_priority->created_by = $user_id;
                    $task_priority->save();
                }
                $general_transcripts_cc = config('laravel_task_manager.client_task_user_transcript_array_id')();
                foreach ($general_transcripts_cc as $transcript_user_id) {
                    $task_transcript = new TaskTranscript();
                    $task_transcript->task_assignment_id = $task_assignment->id;
                    $task_transcript->user_id = $transcript_user_id;
                    $task_transcript->type = 'Cc';
                    $task_transcript->is_active = '1';
                    $task_transcript->created_by = $user_id;
                    $task_transcript->trashed_at = null;
                    $task_transcript->save();
                    $user = config('laravel_task_manager.user_model')::find($transcript_user_id);
                    array_push($description_values_transcripts, $user->full_name);
                    $this->send_notification_to_employe($transcript_user_id, $task->code);

                }
                $general_keywords_array = [];
                foreach ($general_keywords as $keyword) {
                    $general_keywords_array[$keyword] = ['is_active' => 1, 'created_by' => $user_id,];
                }
                $task->keywords()->attach($general_keywords_array);
                LFM_SaveMultiFile($task, 'attachment');
                $description_values = ['assigner' => $user_id, 'employee' => $employee_id, 'transcripts' => serialize($description_values_transcripts),];
                ltm_task_log_store($task->id, config('task_logs.types.create.task'), null, $description_values);
                $this->send_notification_to_employe($employee_id, $task->code);
            }

            $res =
                [
                    'success' => true,
                    'message' => 'با موفقیت انجام شد',
                    'title' => 'ایجاد وظیفه',
                ];

            DB::commit();

            return $res;
        } catch (\Exception $e) {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1'])) {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status' => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getTrackingView(Request $request)
    {
        $assignment_id = ltm_decode_ids($request->input('item_id'), 0);
        $chats = ClientChatHistory::with('user')->where('assignment_id', $assignment_id)->get();
        $user_id = config('laravel_task_manager.task_get_user_id')();
        $variable = $request->variable;
        $assignment = TaskAssignment::with('confirmation')->find($assignment_id);
        $task = Task::where('id', $assignment->task_id)->with('subject', 'assignment.assigner', 'assignment.employee', 'priority', 'keywords', 'logs')->first();
        $LFM_options = ['size_file' => 1000 * 1000 * 4, 'max_file_number' => 1, 'true_file_extension' => ['jpg', 'jpeg', 'png', 'bmp', 'txt', 'xlsx', 'doc', 'docx', 'zip', 'rar'], 'path' => 'task/chat', 'show_file_uploaded' => 'small'];
        $file = LFM_CreateModalUpload('attachment_track', 'callback_track', $LFM_options, 'result_track', 'UploadFileManager_Track', false, 'result_track_button', 'آپلود فایل')['json'];
        $old_file = [];
        $view = view('laravel_task_manager::clients.tasks.panels.jspanel.view.track_task')
            ->with('request_id', $request->request_id)
            ->with('task', $task)
            ->with('chats', $chats)
            ->with('assignment_id', $request->input('item_id'))
            ->with('user_id', $user_id)
            ->with('variable', $variable)
            ->with('file', $file)
            ->with('old_file', json_encode($old_file))
            ->render();
        $res =
            [
                'success' => true,
                'view' => $view,
            ];

        return $res;
    }

    /**
     * @param Client_Response_Request $request
     * @return array
     */
    public function sendClientResponse(Client_Response_Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = config('laravel_task_manager.task_get_user_id')();
            $assignment_id = ltm_decode_ids($request->input('assignment_id'), 0);
            $chat = new ClientChatHistory();
            $chat->assignment_id = $assignment_id;
            $chat->description = $request->description;
            $chat->user_id = $user_id;
            $chat->save();
            $itemFile = LFM_SaveSingleFile($chat, 'file_id', 'attachment_track');
            DB::commit();
            $res = [
                'success' => true,
                'result' => $itemFile
            ];

            return $res;
        } catch (\Exception $e) {
            log_exeption($e);
            DB::rollback();
            if (in_array($request->getClientIp(), ['89.165.122.115', '185.57.167.118', '127.0.0.1'])) {
                dd($e);
            }
            $res =
                [
                    'success' => false,
                    'status' => "-1",
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاعات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return response()->json($res);
        }
    }
}