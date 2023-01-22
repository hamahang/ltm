<?php

namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'ltm_task_logs';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignment()
    {
        return $this->belongsTo('Hamahang\LTM\Models\Tasks\TaskAssignment', 'task_assignment_id', 'id');
    }
}
