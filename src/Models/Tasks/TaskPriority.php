<?php
namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskPriority extends Model
{

    /**
     * @var string
     */
    protected $table = 'ltm_task_priorities';

    /**
     * @var array
     */
    protected $appends =
    [
        'importance_name',
        'immediate_name',
    ];

    /**
     * @param $task_id
     * @param $user_id
     * @param $importance
     * @param $immediate
     * @param null $created_by
     * @return TaskPriority
     */
    public static function store($task_id, $user_id, $importance, $immediate, $created_by = null)
    {
        $r = new TaskPriority();
        $r->task_id = $task_id;
        $r->user_id = $user_id;
        $r->importance = $importance;
        $r->immediate = $immediate;
        $r->created_by = $created_by ? : auth()->id();
        $r->save();
        return $r;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getimportanceNameAttribute()
    {
        return config("tasks.priority.importances.$this->importance");
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getImmediateNameAttribute()
    {
        return config("tasks.priority.immediates.$this->immediate");
    }

}
