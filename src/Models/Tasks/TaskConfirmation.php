<?php

namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskConfirmation extends Model
{
    /**
     * @var string
     */
    protected $table = 'ltm_task_confirmations';

    /**
     * @param $task_assignment_id
     * @param null $created_by
     * @return TaskConfirmation
     */
    public static function store($task_assignment_id, $created_by = null)
    {
        $r = new TaskConfirmation();
        $r->task_assignment_id = $task_assignment_id;
        $r->created_by = $created_by ? : auth()->id();
        $r->save();
        return $r;
    }
}
