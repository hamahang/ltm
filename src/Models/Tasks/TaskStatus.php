<?php

namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    const TYPE_ASSIGNER = 'assigner';
    const TYPE_EMPLOYEE = 'employee';

    /**
     * @var string
     */
    protected $table = 'ltm_task_statuses';

    /**
     * @var array
     */
    protected $appends =
    [
        'status_name',
    ];

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getStatusNameAttribute()
    {
        return config("tasks.statuses.$this->status");
    }

    public function assignment()
    {
        return $this->belongsTo('Hamahang\LTM\Models\Tasks\TaskAssignment', 'task_assignment_id', 'id');
    }

    /**
     * @param $task_assignment_id
     * @param $type
     * @param $status
     * @param $percent
     * @param null $created_by
     * @return TaskStatus
     */
    public static function store($task_assignment_id, $type, $status, $percent, $created_by = null)
    {
        $r = new TaskStatus();
        $r->task_assignment_id = $task_assignment_id;
        $r->type = $type;
        $r->status = $status;
        $r->percent = $percent;
        $r->created_by = $created_by ? : auth()->id();
        $r->save();
        return $r;
    }
}
