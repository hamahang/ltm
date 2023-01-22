<?php

namespace Hamahang\LTM\Helpers\Classes ;

use Hamahang\LTM\Models\Tasks\Task;
use App\User;

class TaskLog
{

    /**
     * @param $user_id
     * @return string
     */
    public static function _get_user_full_name($user_id)
    {
        if ('-1' == $user_id)
        {
            return 'سیستم';
        } else
        {
            $user = User::find($user_id);
            $r = $user ? $user->full_name : 'نا مشخص';
            return $r;
        }
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function create_task_assigner($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function create_task_employee($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function create_task_transcripts($data, $task_id = null)
    {
        $r = null;
        $items = unserialize($data);
        if ($items)
        {
            $r .= '<br />رونوشت گیرندگان:<ul>';
            foreach ($items as $item)
            {
                $r .= "<li>$item</li>";
            }
            $r .= '</ul>';
        }
        return $r;
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_status_old($data, $task_id = null)
    {
        return config("tasks.statuses.$data");
    }

    /**
     * @param $data
     * @param null $task_id
     * @return null|string
     */
    public static function modify_action_do_status_old_percent($data, $task_id = null)
    {
        return $data ? " (%$data)" : null;
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_status_new($data, $task_id = null)
    {
        return config("tasks.statuses.$data");
    }

    /**
     * @param $data
     * @param null $task_id
     * @return null|string
     */
    public static function modify_action_do_status_new_percent($data, $task_id = null)
    {
        return $data ? " (%$data)" : null;
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return null|string
     */
    public static function modify_action_do_status_by($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_importance_old($data, $task_id = null)
    {
        return config("tasks.priority.importances.$data");
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_importance_new($data, $task_id = null)
    {
        return config("tasks.priority.importances.$data");
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_do_importance_by($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_immediate_old($data, $task_id = null)
    {
        return config("tasks.priority.immediates.$data");
    }

    /**
     * @param $data
     * @param null $task_id
     * @return \Illuminate\Config\Repository|mixed
     */
    public static function modify_action_do_immediate_new($data, $task_id = null)
    {
        return config("tasks.priority.immediates.$data");
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_do_immediate_by($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_transfer_transmitter($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_transfer_from($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_transfer_to($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_transfer_transcripts($data, $task_id = null)
    {
        $r = null;
        $items = unserialize($data);
        if ($items)
        {
            $r .= '<br />رونوشت گیرندگان:<ul>';
            foreach ($items as $item)
            {
                $r .= "<li>$item</li>";
            }
            $r .= '</ul>';
        }
        return $r;
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_action_transfer_by($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param $data
     * @param null $task_id
     * @return mixed
     */
    public static function modify_action_transfer_reason($data, $task_id = null)
    {
        return $data;
    }

    /**
     * @param $task_ids
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_old_task_ids($task_ids, $task_id = null)
    {
        $ids = explode(',', $task_ids);
        $tasks = Task::whereIn('id', $ids)->select('title')->get()->toArray();
        return (1 == count($ids)? 'وظیفه' : 'وظایف') . ' ' . implode('</b>، <b>', array_column($tasks, 'title'));
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_old_assigner($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param null $task_id
     * @return mixed
     */
    public static function modify_integrate_old_task_id($task_id = null)
    {
        $task = Task::where('id', $task_id)->select('title')->first();
        return $task->title;
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_old_employee($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }


    /**
     * @param $task_ids
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_new_task_ids($task_ids, $task_id = null)
    {
        $ids = explode(',', $task_ids);
        $tasks = Task::whereIn('id', $ids)->select('title')->get()->toArray();
        return implode('</b>، <b>', array_column($tasks, 'title'));
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_new_assigner($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

    /**
     * @param null $task_id
     * @return mixed
     */
    public static function modify_integrate_new_task_id($task_id = null)
    {
        $task = Task::where('id', $task_id)->select('title')->first();
        return $task->title;
    }

    /**
     * @param $user_id
     * @param null $task_id
     * @return string
     */
    public static function modify_integrate_new_employee($user_id, $task_id = null)
    {
        return self::_get_user_full_name($user_id);
    }

}

//$task = Task::where('id', $task_id)->with('subject', 'assignment.assigner', 'priority', 'keywords', 'transcripts_cc', 'logs')->first();

