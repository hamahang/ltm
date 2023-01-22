<?php

namespace Hamahang\LTM\Controllers\Clients\Tasks;

use App\Jobs\SendSMSArianaSMSPanel;
use App\Jobs\SendSMSMagfaSingleSMS;
use App\Mail\NewTaskNotify;
use Hamahang\LTM\Controllers\Controller;
use Hamahang\LTM\Controllers\KeywordController;
use Hamahang\LTM\Models\Tasks\TaskPriority;
use Hamahang\LTM\Requests\Clients\Tasks\MyTask\Integrate_Request;
use Hamahang\LTM\Requests\Clients\Tasks\Task\Add_Request;
use Hamahang\LTM\Models\Form;
use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\Tasks\Task;
use Hamahang\LTM\Models\Tasks\TaskAssignment;
use Hamahang\LTM\Models\Tasks\TaskStatus;
use Hamahang\LTM\Models\Tasks\TaskTranscript;
use DateTime;
use DB;
use Mail;

class TaskController extends Controller
{

    private function send_email_to_employe($employee_id, $code,$type)
    {
        $user = config('laravel_task_manager.user_model')::find($employee_id);
        $setting = $user->ltm_setting ;
        if ($setting)
        {
            if ($setting->recive_email_is_active == '1')
            {
                $info =
                [
                    'code' => $code,
                    'full_name' => $user->full_name,
                    'email'     => $user->email
                ];
                Mail::to($user->email)->queue((new NewTaskNotify($info))->onQueue('high'));
            }
        }
        else
        {
            $info =
            [
                'code' => $code,
                'full_name' => $user->full_name,
                'email'     => $user->email
            ];
                Mail::to($user->email)->queue((new NewTaskNotify($info))->onQueue('high'));
        }

        return true ;
    }

    private function send_sms_to_employe($employee_id, $code,$type)
    {
        $code = ConvertNumbersEntoFa($code) ;
        $user = config('laravel_task_manager.user_model')::find($employee_id);
        $setting = $user->ltm_setting ;
        switch ($type)
        {
            case 'cc':
                $text = ' یک وظیفه جدید با شناسه ' . $code . ' در سامانه سیفام ایجاد شده است .';
                break ;
            case 'bbc':
                $text = 'یک وظیفه جدید با شناسه' . $code . ' در سامانه سیفام ایجاد شده است .';
                break ;
            default :
                $text = 'برای شما یک وظیفه جدید با شناسه ' . $code . ' در سامانه سیفام ایجاد شده است .';
        }

        if ($setting)
        {
            if ($setting->recive_sms_is_active == '1')
            {
                if (config('magfa_sms.send_from') == 'magfa')
                {
                    dispatch((new SendSMSMagfaSingleSMS($text, $user->mobile))->onQueue('high'));
                }
                else
                {
                    dispatch((new SendSMSArianaSMSPanel($text, $user->mobile))->onQueue('high'));
                }
            }
        }
        else
        {
            if (config('magfa_sms.send_from') == 'magfa')
            {
                dispatch((new SendSMSMagfaSingleSMS($text, $user->mobile))->onQueue('high'));
            }
            else
            {
                dispatch((new SendSMSArianaSMSPanel($text, $user->mobile))->onQueue('high'));
            }

        }

        return true ;
    }

    /**
     * @param $input
     * @return array|string
     */
    public function make_date($input)
    {
        return ltm_Date_JtoG($input, '/', true, '-', true);
    }

    /**
     * @param $input
     * @return string
     */
    public function make_time($input)
    {
        return ltm_ConvertNumbersFatoEn($input) . ':00';

    }

    /**
     * @param $start_datetime
     * @param $end_date
     * @param $end_time
     * @return float|int
     */
    public function make_duration_by_datetime($start_datetime, $end_date, $end_time)
    {
        $start = new DateTime($start_datetime);
        $end = new DateTime("$end_date $end_time");
        $diff = $start->diff($end);
        return ($diff->days * 24 * 60) + ($diff->h * 60) + ($diff->i);
    }

    /**
     * @param Add_Request $request
     * @return TaskController
     * @throws \Exception
     * @throws \Throwable
     */
    public function add(Add_Request $request)
    {
        DB::beginTransaction();
        try
        {
            // initialize variables for general
            $general_type = $request->input('general_type');
            $general_importance = $request->input('general_importance', false);
            $general_immediate = $request->input('general_immediate', false);
            $general_title = $request->input('general_title');
            $general_subject_id = $request->input('general_subject_id');
            $general_description = $request->input('general_description', null);
            $general_users = $request->input('general_users');
            $general_transcripts_cc = $request->input('general_transcripts_cc', []);
            $general_transcripts_bcc = $request->input('general_transcripts_bcc', []);
            $general_keywords = KeywordController::make($request->input('general_keywords', []));
            $general_deadline = $request->input('general_deadline');
            $general_file_no = $request->input('general_file_no');
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
            $setting_transferable = (string) (int) (bool) $request->input('setting_transferable', '0');
            $setting_end_on_assigner_accept = (string) (int) (bool) $request->input('setting_end_on_assigner_accept', '0');
            $setting_rejectable = (string) (int) (bool) $request->input('setting_rejectable', '0');
            // initialize variables for schedule
            $schedule_every = $request->input('schedule_every');
            $schedule_every_type = $request->input('schedule_every_type');
            $schedule_begin_by = $request->input('schedule_begin_by');
            $schedule_begin_by_date_value = $request->input('schedule_begin_by_date_value');
            $schedule_end_by = $request->input('schedule_end_by');
            $schedule_creation = $request->input('schedule_creation');
            // insert
            if (!check_subject_task_permission($general_subject_id))
            {
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
            if (!check_user_task_permission($general_users))
            {
                $res =
                    [
                        'success' => false,
                        'message' =>
                            [
                                [
                                    'title' => 'لطفاً موارد زیر را بررسی نمایید',
                                    'items' => [0 => 'مسئولین معتبر نمیباشند .'],
                                ],
                            ],
                    ];
                DB::commit();

                return $res;
            }
            foreach ($general_users as $employee_id)
            {
                // task
                $description_values_transcripts = [];
                $start_datetime = date('Y-m-d H:i:00');
                $duration_integer = 0;
                switch ($general_deadline)
                {
                    case '1':
                        break;
                    case '2':
                        $general_deadline_from = $request->input('general_deadline_from');
                        switch ($general_deadline_from)
                        {
                            case '1':
                                break;
                            case '2':
                                $general_deadline_from_date = $this->make_date($request->input('general_deadline_from_date'));
                                $general_deadline_from_time = $this->make_time($request->input('general_deadline_from_time'));
                                $start_datetime = "$general_deadline_from_date $general_deadline_from_time";
                                break;
                        }
                        $general_deadline_to = $request->input('general_deadline_to');
                        switch ($general_deadline_to)
                        {
                            case '1':
                                $general_deadline_to_day = $request->input('general_deadline_to_day');
                                $general_deadline_to_hour = explode(':', $request->input('general_deadline_to_hourmin'))[0];
                                $general_deadline_to_min = explode(':', $request->input('general_deadline_to_hourmin'))[1];
                                $duration_integer = ($general_deadline_to_day * 24 * 60) + ($general_deadline_to_hour * 60) + ($general_deadline_to_min);
                                break;
                            case '2':
                                $general_deadline_to_date = $this->make_date($request->input('general_deadline_to_date'));
                                $general_deadline_to_time = $this->make_time($request->input('general_deadline_to_time'));
                                $duration_integer = $this->make_duration_by_datetime($start_datetime, $general_deadline_to_date, $general_deadline_to_time);
                                break;
                        }
                        break;
                    default:
                        break;
                }
                $task = new Task();
                $task->title = $general_title;
                $task->subject_id = $general_subject_id;
                $task->description = $general_description;
                $task->type = $general_type;
                $task->file_no = $general_file_no;
                $task->start_time = $start_datetime;
                $task->duration_timestamp = $duration_integer;
                $task->schedule_id = 0;
                $task->template_id = 0;
                $task->is_active = '1';
                $task->created_by = auth()->id();
                $task->started_by = auth()->id();
                $task->code = microtime();
                $task->save();
                $code = ltm_make_task_code(Subject::find($general_subject_id)->code, $task->id) ;
                $task->code = $code;
                $task->save();
                // assignment
                $task_assignment = new TaskAssignment();
                $task_assignment->task_id = $task->id;
                $task_assignment->employee_id = $employee_id;
                $task_assignment->assigner_id = auth()->id();
                $task_assignment->transferred_to_id = 0;
                $task_assignment->transmitter_id = 0;
                $task_assignment->integrated_task_id = 0;
                $task_assignment->rejected_at = null;
                $task_assignment->action_do_form_id = $setting_action_do_form_id;
                if ($setting_action_do_form_id)
                {
                    $task_assignment->action_do_fields_code = Form::generate_fields_code($setting_action_do_form_id);
                }
                $task_assignment->action_transfer_form_id = $setting_action_transfer_form_id;
                if ($setting_action_transfer_form_id)
                {
                    $task_assignment->action_transfer_fields_code = Form::generate_fields_code($setting_action_transfer_form_id);
                }
                $task_assignment->action_reject_form_id = $setting_action_reject_form_id;
                if ($setting_action_reject_form_id)
                {
                    $task_assignment->action_reject_fields_code = Form::generate_fields_code($setting_action_reject_form_id);
                }
                $task_assignment->transferable = $setting_transferable;
                $task_assignment->end_on_assigner_accept = $setting_end_on_assigner_accept;
                $task_assignment->rejectable = $setting_rejectable;
                $task_assignment->created_by = auth()->id();
                $task_assignment->save();
                // status
                $task_status = new TaskStatus();
                $task_status->task_assignment_id = $task_assignment->id;
                $task_status->type = TaskStatus::TYPE_ASSIGNER;
                $task_status->status = 0;
                $task_status->percent = 0;
                $task_status->created_by = auth()->id();
                $task_status->save();
                // priority
                foreach ([auth()->id(), $employee_id] as $task_auth_and_employee_id)
                {
                    $task_priority = new TaskPriority();
                    $task_priority->task_id = $task->id;
                    $task_priority->user_id = $task_auth_and_employee_id;
                    $task_priority->importance = $general_importance;
                    $task_priority->immediate = $general_immediate;
                    $task_priority->created_by = auth()->id();
                    $task_priority->save();
                }
                // transcript_cc
                foreach ($general_transcripts_cc as $user_id)
                {
                    $task_transcript = new TaskTranscript();
                    $task_transcript->task_assignment_id = $task_assignment->id;
                    $task_transcript->user_id = $user_id;
                    $task_transcript->type = 'Cc';
                    $task_transcript->is_active = '1';
                    $task_transcript->created_by = auth()->id();
                    $task_transcript->trashed_at = null;
                    $task_transcript->save();
                    $user = config('laravel_task_manager.user_model')::find($user_id);
                    array_push($description_values_transcripts, $user->full_name);
                    if ($setting_sms_is_active && $setting_sms_transcripts && config('laravel_task_manager.send_sms_after_task_create_from_backend'))
                    {
                        $this->send_sms_to_employe($user_id,$code,'cc');
                    }

                    if ($setting_email_is_active && $setting_email_transcripts && config('laravel_task_manager.send_email_after_task_create_from_backend'))
                    {
                        $this->send_email_to_employe($user_id,$code,'cc');
                    }
                }
                // transcript_bcc
                foreach ($general_transcripts_bcc as $user_id)
                {
                    $task_transcript = new TaskTranscript();
                    $task_transcript->task_assignment_id = $task_assignment->id;
                    $task_transcript->user_id = $user_id;
                    $task_transcript->type = 'Bcc';
                    $task_transcript->is_active = '1';
                    $task_transcript->created_by = auth()->id();
                    $task_transcript->trashed_at = null;
                    $task_transcript->save();
                    if ($setting_sms_is_active && $setting_sms_transcripts && config('laravel_task_manager.send_sms_after_task_create_from_backend'))
                    {
                        $this->send_sms_to_employe($user_id,$code,'bcc');
                    }

                    if ($setting_email_is_active && $setting_email_transcripts && config('laravel_task_manager.send_email_after_task_create_from_backend'))
                    {
                        $this->send_email_to_employe($user_id,$code,'bcc');
                    }
                }
                $general_keywords_array = [];
                foreach ($general_keywords as $keyword)
                {
                    $general_keywords_array[$keyword] = ['is_active' => 1, 'created_by' => auth()->id(), ];
                }
                $task->keywords()->attach($general_keywords_array);
                LFM_SaveMultiFile($task, 'attachment');
                $description_values = ['assigner' => auth()->id(), 'employee' => $employee_id, 'transcripts' => serialize($description_values_transcripts), ];
                ltm_task_log_store($task->id, config('task_logs.types.create.task'), null, $description_values);
                if ($setting_sms_is_active && $setting_sms_users && config('laravel_task_manager.send_sms_after_task_create_from_backend'))
                {
                    $this->send_sms_to_employe($employee_id,$code,'new');
                }

                if ($setting_email_is_active && $setting_email_users && config('laravel_task_manager.send_email_after_task_create_from_backend'))
                {
                    $this->send_email_to_employe($employee_id,$code,'new');
                }
            }

            DB::commit();

            return $this->add_success();
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
     * @return $this
     */
    function add_success()
    {
        $r =
        [
            'status' => '1',
            'success' => true,
            'status_type' => 'success',
            'errors' => null,
            'reload' => true,
            'message' => 'با موفقیت انجام شد',
            'title' => 'ایجاد وظیفه',
            'url' => route(config('laravel_task_manager.site_assigned_task_route')),
        ];
        return response()->json($r, 200)->withHeaders(['content-type' => 'text/plain', 'charset' => 'utf-8']);
    }

    /**
     * @param Integrate_Request $request
     * @return json
     * @throws \Exception
     * @throws \Throwable
     */
    function integrate(Integrate_Request $request)
    {
        DB::transaction(function() use ($request)
        {
            // initialize hidden variables
            $hashed_ids = $request->input('hashed_ids');
            // initialize variables for general
            $general_type = $request->input('general_type');
            $general_importance = $request->input('general_importance', false);
            $general_immediate = $request->input('general_immediate', false);
            $general_title = $request->input('general_title');
            $general_subject_id = $request->input('general_subject_id');
            $general_description = $request->input('general_description');
            $general_user = $request->input('general_user');
            $general_transcripts_cc = $request->input('general_transcripts_cc', []);
            $general_transcripts_bcc = $request->input('general_transcripts_bcc', []);
            $general_keywords = KeywordController::make($request->input('general_keywords', []));
            $general_deadline = $request->input('general_deadline');
            $general_file_no = $request->input('general_file_no');
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
            $setting_transferable = (bool) $request->input('setting_transferable', '0');
            $setting_end_on_assigner_accept = (bool) $request->input('setting_end_on_assigner_accept', '0');
            $setting_rejectable = (bool) $request->input('setting_rejectable', '0');
            // initialize variables for schedule
            $schedule_every = $request->input('schedule_every');
            $schedule_every_type = $request->input('schedule_every_type');
            $schedule_begin_by = $request->input('schedule_begin_by');
            $schedule_begin_by_date_value = $request->input('schedule_begin_by_date_value');
            $schedule_end_by = $request->input('schedule_end_by');
            $schedule_creation = $request->input('schedule_creation');
            // insert
            $start_datetime = date('Y-m-d H:i:00');
            $duration_integer = 0;
            $ids = ltm_decode_ids($hashed_ids);
            switch ($general_deadline)
            {
                case '1':
                    break;
                case '2':
                    $general_deadline_from = $request->input('general_deadline_from');
                    switch ($general_deadline_from)
                    {
                        case '1':
                            break;
                        case '2':
                            $general_deadline_from_date = $this->make_date($request->input('general_deadline_from_date'));
                            $general_deadline_from_time = $this->make_time($request->input('general_deadline_from_time'));
                            $start_datetime = "$general_deadline_from_date $general_deadline_from_time";
                            break;
                    }
                    $general_deadline_to = $request->input('general_deadline_to');
                    switch ($general_deadline_to)
                    {
                        case '1':
                            $general_deadline_to_day = $request->input('general_deadline_to_day');
                            $general_deadline_to_hour = explode(':', $request->input('general_deadline_to_hourmin'))[0];
                            $general_deadline_to_min = explode(':', $request->input('general_deadline_to_hourmin'))[1];
                            $duration_integer = ($general_deadline_to_day * 24 * 60) + ($general_deadline_to_hour * 60) + ($general_deadline_to_min);
                            break;
                        case '2':
                            $general_deadline_to_date = $this->make_date($request->input('general_deadline_to_date'));
                            $general_deadline_to_time = $this->make_time($request->input('general_deadline_to_time'));
                            $duration_integer = $this->make_duration_by_datetime($start_datetime, $general_deadline_to_date, $general_deadline_to_time);
                            break;
                    }
                    break;
                default:
                    break;
            }
            $task = new Task();
            $task->title = $general_title;
            $task->subject_id = $general_subject_id;
            $task->description = $general_description;
            $task->type = $general_type;
            $task->transferable = $setting_transferable;
            $task->end_on_assigner_accept = $setting_end_on_assigner_accept;
            $task->rejectable = $setting_rejectable;
            $task->file_no = $general_file_no;
            $task->start_time = $start_datetime;
            $task->duration_timestamp = $duration_integer;
            $task->schedule_id = 0;
            $task->template_id = 0;
            $task->is_active = '1';

            $task->created_by = auth()->id();
            $task->started_by = auth()->id();

            $task->code = microtime();

            $task->save();
            $task->code = ltm_make_task_code(Subject::find($general_subject_id)->code, $task->id);
            $task->save();
            $description_values =
            [
                'task_ids' => implode(',', $ids),
                'assigner' => auth()->id(),
                'task_id' => $task->id,
                'employee' => $general_user,
            ];
            ltm_task_log_store($task->id, config('task_logs.types.modify.integrate.new'), $description_values);
            // status
            $task_status = new TaskStatus();
            $task_status->task_id = $task->id;
            $task_status->user_id = auth()->id();
            $task_status->status = 0;
            $task_status->percent = 0;
            $task_status->created_by = auth()->id();
            $task_status->save();
            // priority
            foreach ([auth()->id(), $general_user] as $task_auth_and_employee_id)
            {
                $task_priority = new TaskPriority();
                $task_priority->task_id = $task->id;
                $task_priority->user_id = $task_auth_and_employee_id;
                $task_priority->importance = $general_importance;
                $task_priority->immediate = $general_immediate;
                $task_priority->created_by = auth()->id();
                $task_priority->save();
            }
            // assignment
            $task_assignment = new TaskAssignment();
            $task_assignment->task_id = $task->id;
            $task_assignment->assigner_id = auth()->id();
            $task_assignment->employee_id = $general_user;
            $task_assignment->transferred_to_id = 0;
            $task_assignment->transmitter_id = 0;
            $task_assignment->integrated_task_id = 0;
            $task_assignment->rejected_at = null;
            $task_assignment->action_do_form_id = $setting_action_do_form_id;
            if ($setting_action_do_form_id)
            {
                $task_assignment->action_do_fields_code = Form::generate_fields_code($setting_action_do_form_id);
            }
            $task_assignment->action_transfer_form_id = $setting_action_transfer_form_id;
            if ($setting_action_transfer_form_id)
            {
                $task_assignment->action_transfer_fields_code = Form::generate_fields_code($setting_action_transfer_form_id);
            }
            $task_assignment->action_reject_form_id = $setting_action_reject_form_id;
            if ($setting_action_reject_form_id)
            {
                $task_assignment->action_reject_fields_code = Form::generate_fields_code($setting_action_reject_form_id);
            }
            $task_assignment->is_active = '1';
            $task_assignment->created_by = auth()->id();
            $task_assignment->save();
            // transcript_cc
            foreach ($general_transcripts_cc as $user_id)
            {
                $task_transcript = new TaskTranscript();
                $task_transcript->task_assignment_id = $task_assignment->id;
                $task_transcript->user_id = $user_id;
                $task_transcript->type = 'Cc';
                $task_transcript->is_active = '1';
                $task_transcript->created_by = auth()->id();
                $task_transcript->trashed_at = null;
                $task_transcript->save();
            }
            // transcript_bcc
            foreach ($general_transcripts_bcc as $user_id)
            {
                $task_transcript = new TaskTranscript();
                $task_transcript->task_assignment_id = $task_assignment->id;
                $task_transcript->user_id = $user_id;
                $task_transcript->type = 'Bcc';
                $task_transcript->is_active = '1';
                $task_transcript->created_by = auth()->id();
                $task_transcript->trashed_at = null;
                $task_transcript->save();
            }
            $general_keywords_array = [];
            foreach ($general_keywords as $keyword)
            {
                $general_keywords_array[$keyword] = ['is_active' => 1, 'created_by' => 0, ];
            }
            $task->keywords()->attach($general_keywords_array);
            // update assignment
            foreach ($ids as $id)
            {
                $assignment = Task::where('id', $id)->first()->assignments()->where('task_assignments.employee_id', auth()->id())->where('ltm_task_assignments.transferred_to_id', '0')->where('ltm_task_assignments.transmitter_id', '0')->where('ltm_task_assignments.integrated_task_id', '0')->whereNull('ltm_task_assignments.rejected_at')->first();
                $assignment->integrated_task_id = $task->id;
                $assignment->save();
                $description_values =
                [
                    'task_ids' => implode(',', array_diff($ids, [$id])),
                    'assigner' => auth()->id(),
                    'task_id' => $task->id,
                    'employee' => $general_user,
                ];
                ltm_task_log_store($id, config('task_logs.types.modify.integrate.old'), null, $description_values);
            }
        });
        return $this->integrate_success();
    }

    /**
     * @return json
     */
    function integrate_success()
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

    public function create_task_view()
    {
        $LFM_options = ['size_file' => 1000, 'max_file_number' => 5, 'min_file_number' => 2, 'show_file_uploaded' => 'medium', 'true_file_extension' => ['jpg', 'jpeg', 'png', 'bmp', 'txt', 'xlsx', 'doc', 'docx', 'zip', 'rar'], 'path' => 'test'];
        $LFM = LFM_CreateModalFileManager('attachment', $LFM_options, 'insert', 'callback', null, null, null, 'انتخاب فایل/ها');
        $subjects = Subject::all();
        $setting = auth()->user()->ltm_setting ;
        return view('laravel_task_manager::clients.tasks.create_task.index',compact('LFM', 'subjects','setting'));
    }
}
