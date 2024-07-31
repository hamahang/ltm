<?php
namespace App\Traits ;

use Hamahang\LTM\Models\Tasks\Task;
use Hamahang\LTM\Models\Tasks\TaskAssignment;

trait ltmUserTrait {

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function my_tasks_assignments()
    {
        $where =
            [
                ['ltm_task_assignments.transmitter_id', '=', '0'],
                ['ltm_task_assignments.transferred_to_id', '=', '0'],
                ['ltm_task_assignments.integrated_task_id', '=', '0'],
                ['ltm_task_assignments.rejected_at', null, 'IS NULL'],
                ['ltm_task_assignments.is_active', '1'],
            ];
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskAssignment', 'employee_id', 'id')->where($where);
    }

    public function my_tasks_assigners()
    {
        return $this->belongsToMany('App\User', 'ltm_task_assignments', 'employee_id', 'assigner_id')->distinct();
    }

    public function getMyTasksAttribute()
    {
        return Task::whereHas('assignments', function($query)
        {
            $where =
                [
                    ['ltm_task_assignments.employee_id', '=', $this->id],
                    ['ltm_task_assignments.transmitter_id', '=', '0'],
                    ['ltm_task_assignments.transferred_to_id', '=', '0'],
                    ['ltm_task_assignments.integrated_task_id', '=', '0'],
                    ['ltm_task_assignments.rejected_at', null, 'IS NULL'],
                    ['ltm_task_assignments.is_active', '1'],
                ];
            $query->where($where);
        });
    }

    public function getMyNewTasksAttribute()
    {
        return Task::whereHas('assignments', function($query)
        {
            $where =
                [
                    ['ltm_task_assignments.employee_id', '=', $this->id],
                    ['ltm_task_assignments.transmitter_id', '=', '0'],
                    ['ltm_task_assignments.transferred_to_id', '=', '0'],
                    ['ltm_task_assignments.integrated_task_id', '=', '0'],
                    ['ltm_task_assignments.rejected_at', null, 'IS NULL'],
                    ['ltm_task_assignments.is_active', '1'],
                ];
            $query->where($where)->whereDoesntHave('visits', function($q) { $q->where('user_id', auth()->id()); });
        });
    }

    public function getMyTasksAssignersForSelect2Attribute()
    {
        $r = [];
        foreach ($this->my_tasks_assigners as $v)
        {
            $r[] = ['id' => $v->id, 'text' => $v->full_name];
        }
        return response()->json($r);
    }

    /**
     * my_assigned_tasks
     *
     *
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function my_assigned_tasks_assignments()
    {
        $rows = $this->hasMany('Hamahang\LTM\Models\Tasks\TaskAssignment', 'assigner_id', 'id')->groupBy('task_id');
        return $rows;
    }

    public function my_assigned_tasks_employees()
    {
        return $this->belongsToMany('App\User', 'ltm_task_assignments', 'assigner_id', 'employee_id')->distinct();
    }

    public function getMyAssignedTasksAttribute()
    {
        return Task::whereHas('assignments', function($query)
        {
            $where =
                [
                    ['ltm_task_assignments.assigner_id', '=', $this->id],
                    ['ltm_task_assignments.is_active', '1'],
                ];
            $query->where($where);
        });
    }

    public function getMyAssignedTasksEmployeesForSelect2Attribute()
    {
        $r = [];
        foreach ($this->my_assigned_tasks_employees as $v)
        {
            $r[] = ['id' => $v->id, 'text' => $v->full_name];
        }
        return response()->json($r);
    }

    /**
     * transcripts
     *
     *
     */
    public function my_transcript_tasks()
    {
        return $this->belongsToMany('Hamahang\LTM\Models\Tasks\Task', 'ltm_task_transcripts', 'user_id', 'task_id')
            ->whereNull('ltm_task_transcripts.trashed_at')
            ->whereNull('ltm_task_transcripts.deleted_at')
            ->select('ltm_task_transcripts.user_id', 'ltm_task_transcripts.task_id', 'tasks.*');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function my_transcript_assignments()
    {
        return $this->belongsToMany('Hamahang\LTM\Models\Tasks\TaskAssignment', 'ltm_task_transcripts', 'user_id', 'task_assignment_id')
            ->whereNull('ltm_task_transcripts.trashed_at')
            ->whereNull('ltm_task_transcripts.deleted_at')
            ->select('ltm_task_assignments.*');
    }

    public function getMyTranscriptTasksAssignersAndEmployeesForSelect2Attribute()
    {
        $r = ['assigners' => [], 'employees' => [], ];
        $assigners_and_employee = TaskAssignment::with('assigner', 'employee')
            ->whereHas('transcript', function($query) { $query->where('ltm_task_transcripts.user_id', auth()->id())->whereNull('trashed_at'); })
            ->get();
        foreach ($assigners_and_employee as $v)
        {
            $r['assigners'][] = ['id' => $v->assigner->id, 'text' => $v->assigner->full_name];
            $r['employees'][] = ['id' => $v->employee->id, 'text' => $v->employee->full_name];
        }
        $r['assigners'] = json_encode($r['assigners']);
        $r['employees'] = json_encode($r['employees']);
        return $r;
    }

    /**
     * transcripts_trash
     *
     *
     */
    public function my_transcript_tasks_trash()
    {
        return $this->belongsToMany('Hamahang\LTM\Models\Tasks\Task', 'ltm_task_transcripts', 'user_id', 'task_id')
            ->whereNotNull('ltm_task_transcripts.trashed_at')
            ->whereNull('ltm_task_transcripts.deleted_at')
            //->withPivot('id')
            ->select('ltm_task_transcripts.user_id', 'ltm_task_transcripts.task_id', 'tasks.*');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function my_transcript_assignments_trash()
    {
        return $this->belongsToMany('Hamahang\LTM\Models\Tasks\TaskAssignment', 'ltm_task_transcripts', 'user_id', 'task_assignment_id')
            ->whereNotNull('ltm_task_transcripts.trashed_at')
            ->whereNull('ltm_task_transcripts.deleted_at')
            ->select('ltm_task_assignments.*');
    }

    /**
     * @return array
     */
    public function getMyTranscriptTasksTrashAssignersAndEmployeesForSelect2Attribute()
    {
        $r = ['assigners' => [], 'employees' => [], ];
        $assigners_and_employee = TaskAssignment::with('assigner', 'employee')
            ->whereHas('transcript', function($query) { $query->where('ltm_task_transcripts.user_id', auth()->id())->whereNotNull('trashed_at'); })
            ->get();
        foreach ($assigners_and_employee as $v)
        {
            $r['assigners'][] = ['id' => $v->assigner->id, 'text' => $v->assigner->full_name];
            $r['employees'][] = ['id' => $v->employee->id, 'text' => $v->employee->full_name];
        }
        $r['assigners'] = json_encode($r['assigners']);
        $r['employees'] = json_encode($r['employees']);
        return $r;
    }
    public function getUrlAttribute()
    {
        return route(config('laravel_task_manager.task_profile_client_route_name')) ;
//        return url('/user/' . $this->id);
    }
    public function getImageAttribute()
    {
        return $this->avatar_image;
    }
    public function getAvatarImageAttribute()
    {
        return LFM_GenerateDownloadLink('ID', $this->avatar_file_id, 'original', '404_user_avatar.jpg');
    }
    public function getAvatar32Attribute()
    {
        return '<a href="' . $this->url . '" target="_blank"><img src="' . $this->avatar_image . '" style="border: gray solid 1px; height: 32px; padding: 2px; width: 32px; border-radius: 2px;" />&nbsp;&nbsp;' . $this->full_name . ' (' . $this->username . ')' . '</a>';
    }
    public function getAvatar64Attribute()
    {
        return '<a href="' . $this->url . '" target="_blank"><img src="' . $this->avatar_image . '" style="border: gray solid 1px; height: 64px; padding: 2px; width: 64px; border-radius: 2px;" /></a>';
    }

    public function getAvatarFileManagerAttribute()
    {

        $LFM_ShowingleFile = LFM_ShowingleFile($this,'img_id','options');
        return $LFM_ShowingleFile['view']['medium'];
    }

    public function ltm_setting()
    {
        return $this->hasOne('Hamahang\LTM\Models\Setting');
    }
}
