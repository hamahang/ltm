<?php

namespace Hamahang\LTM\Models\Tasks;

use Hamahang\LTM\Models\Subject;
use Hamahang\LTM\Models\SubjectSetting;
use App\Traits\lfmFillable;
use DateInterval;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

/**
 * Class Task
 * @package Hamahang\LTM\Models\Tasks
 */
class Task extends Model
{
    /**
     *
     */
    use lfmFillable;

    /**
     * @var string
     */
    protected $table = 'ltm_tasks';

    /**
     * @var string
     */
    var $color_danger = '<span style="color: #f44336; font-weight: bold;">%s</span>';

    /**
     * @var string
     */
    var $color_success = '<span style="color: #4caf50; font-weight: bold;">%s</span>';

    /**
     * @var string
     */
    var $color_warning = '<span style="color: #ff5722; font-weight: bold;">%s</span>';

    /**
     * @var string
     */
    var $color_disabled = '<span style="color: lightgray; font-weight: bold;">%s</span>';


    /*
     * relations
     *
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function keywords()
    {
        return $this->morphToMany('Hamahang\LTM\Models\Keyword', 'target', 'ltm_keywordables', 'target_id', 'keyword_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function subject()
    {
        return $this->hasOne('Hamahang\LTM\Models\Subject', 'id', 'subject_id') ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function creator()
    {
        return $this->hasOne(config('laravel_task_manager.user_model'), 'id', 'started_by')
            ->select('users.*');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function assignment()
    {
        return $this->hasOne('Hamahang\LTM\Models\Tasks\TaskAssignment', 'task_id', 'id')
            ->where('ltm_task_assignments.transferred_to_id', '0')
            ->where('ltm_task_assignments.transmitter_id', '0')
            ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignments()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskAssignment', 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function priority()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskPriority', 'task_id', 'id')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskStatus', 'task_id', 'id')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transcripts()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transcripts_cc()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id')
            ->where('type', 'Cc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transcripts_bcc()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id')
            ->where('type', 'Bcc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskLog', 'task_id', 'id')
            ->orderBy('id', 'desc');
    }

    /*
     * attributes
     *
     */

    /**
     * Convert 'start_time' to Jalali date.
     *
     * @return string
     */
    public function getJalaliStartTimeAttribute()
    {
        return ltm_Date_GtoJ($this->attributes['start_time'], 'مورخ Y/m/d ساعت H:i', true);
    }

    /**
     * Check whether we`ve reached to 'start_time'.
     *
     * @return bool
     */
    public function getStartTimeReachedAttribute()
    {
        if (0 == $this->duration_timestamp)
        {
            return true;
        } else
        {
            $start = $this->attributes['start_time'];
            $now = date('Y-m-d H:i:00');
            return $start <= $now;
        }
    }

    /**
     * Check whether 'duration_timestamp' is over.
     *
     * @return bool
     * @throws \Exception
     */
    public function getDurationExpiredAttribute()
    {
        if (0 == $this->duration_timestamp)
        {
            return true;
        } else
        {
            $start = new DateTime($this->attributes['start_time']);
            $start->add(new DateInterval('PT' . $this->duration_timestamp . 'M'));
            $now = new DateTime(date('Y-m-d H:i:00'));
            return $start <= $now;
        }
    }

    /**
     * Make 'duration_timestamp' human readable using 'ltm_minutes_to_time'.
     *
     * @return array
     */
    public function getHumanDurationTimestampAttribute()
    {
        if (0 == $this->duration_timestamp)
        {
            return sprintf($this->color_danger, 'آنی');
        } else
        {
            return ltm_minutes_to_time($this->duration_timestamp, true);
        }
    }

    /**
     * Calculate remaining duration time
     *
     * @return float|int|mixed
     */
    public function getRemainingDurationTimestampAttribute()
    {
        $start = $this->attributes['start_time'];
        $now = date('Y-m-d H:i:00');
        $elapsed_from_start_to_now = ltm_date_diff_seconds($start, $now, true);
        $remaning_from_now = $this->duration_timestamp - $elapsed_from_start_to_now;
        return $remaning_from_now;
    }

    /**
     * Make 'remaining_duration_timestamp' human readable.
     *
     * @return string
     */
    public function getHumanRemainingDurationTimestampAttribute()
    {
        if (0 == $this->duration_timestamp)
        {
            return sprintf($this->color_danger, 'آنی');
        } elseif (!$this->start_time_reached)
        {
            return sprintf($this->color_disabled, 'زمان شروع نرسیده');
        } elseif ($this->duration_expired)
        {
            return sprintf($this->color_danger, 'گذشته');
        } else
        {
            $out = ltm_minutes_to_time($this->remaining_duration_timestamp);
            return sprintf($this->color_success, $out['text']);
        }
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|null|object
     */
    public function getAssignerPriorityAttribute()
    {
        return $this->priority()->where('user_id', $this->assignment->assigner_id)->first();
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|mixed|null|object
     */
    public function getEmployeePriorityAttribute()
    {
        $r = $this->priority()->where('user_id', $this->assignment->employee_id)->first();
        return $r ? $r : $this->assigner_priority;
    }

    /**
     * @return mixed
     */
    public function getFileDataAttribute()
    {
        $subject = Subject::find($this->subject_id);
        $SubjectSetting = SubjectSetting::where('subject_id',$subject->id)->where('type','1')->first();
        if($SubjectSetting)
        {
            $form_params['report_id'] = $SubjectSetting->report_id;
            $form_params['token'] = $SubjectSetting->token;
            if (isset($this->file_no))
            {
                $form_params['conditions'] = json_encode([$SubjectSetting->column_id => $this->file_no]);
            }
            $temp = [];
            foreach (explode(',', $SubjectSetting->template_id) as $key => $param)
            {
                $temp = array_merge($temp, [$key => $param]);
            }
            $form_params['templates'] = json_encode($temp);
            $form_params['array'] = 'true';
            $form_params['template'] = 'true';
            $form_params['form_params'] = $form_params;
            // send data with guzzle
            $client = new Client();
            try
            {
                $response = $client->post($SubjectSetting->url, $form_params);
            } catch (\Exception $e)
            {
                $message['status'] = '0';
                $message['data'] = 'امکان دریافت اطلاعات نمی باشد.';
                return $message;
            }
            $data = $response->getBody()->getContents();
            $bom = pack('H*', 'EFBBBF');
            $text = preg_replace("/^$bom/", '', $data);
            $data_decode = json_decode($text);
            if ($data_decode->status == '1')
            {
                if (isset($this->file_no))
                {
                    foreach($data_decode->items as $arr_param)
                    {
                        $array_data[] = $arr_param;
                    }
                } else
                {
                    $num = 0;
                    foreach ($data_decode->data as $arr_param)
                    {
                        $text_concat = '';
                        foreach ($arr_param as $key => $param)
                        {
                            if ($key == $SubjectSetting->column_id)
                            {
                                $array_data[$num]['id'] = (int)$param;
                            }
                            if (in_array($key, explode(',', $SubjectSetting->column_concat)))
                            {
                                if ($text_concat != '')
                                {
                                    $text_concat .= ' _ ' . $param;
                                } else
                                {
                                    $text_concat .= $param;
                                }
                            }
                        }
                        $array_data[$num]['text'] = $text_concat;
                        $num++;
                    }
                }
                $message['status'] = '1';
                $message['data'] = $array_data;
                return $message;
            } else
            {
                $message['status'] = '0';
                $message['data'] = 'امکان دریافت اطلاعات نمی باشد.';
                return $message;
            }
        } else
        {
            $message['status'] = '0';
            $message['data'] = 'تنظیمات موضوع برای اتصال کامل نیست.';
            return $message;
        }
    }

    public function getStepNameAttribute()
    {
        $step = config('laravel_task_manager.task_get_step_function_name')($this->step_id) ;
        if ($step && isset($step['title']))
        {
            return $step['title'] ;
        }
        else
        {
            return false ;
        }
    }


}
