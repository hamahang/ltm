<?php

namespace Hamahang\LTM\Models\Tasks;

use App\Traits\lfmFillable;
use App\Traits\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskAssignment
 * @package Hamahang\LTM\Models\Tasks
 */
class TaskAssignment extends Model
{
    /**
     *
     */
    use lfmFillable;

    /**
     *
     */
    use Models;

    /**
     * @var string
     */
    protected $table = 'ltm_task_assignments';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assigner()
    {
        return $this->hasOne(config('laravel_task_manager.user_model'), 'id', 'assigner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->belongsTo(config('laravel_task_manager.user_model'), 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transferred_to()
    {
        return $this->hasOne(config('laravel_task_manager.user_model'), 'id', 'transferred_to_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transmitter()
    {
        return $this->hasOne(config('laravel_task_manager.user_model'), 'id', 'transmitter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transcript()
    {
        return $this->hasOne('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id');
    }

    public function transcripts()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id');
    }

    public function transcripts_cc()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id')
            ->where('type', 'Cc');
    }

    public function transcripts_bcc()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskTranscript', 'task_assignment_id', 'id')
            ->where('type', 'Bcc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->belongsTo('Hamahang\LTM\Models\Tasks\Task', 'task_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function form_results()
    {
        return $this->morphMany('Hamahang\LTM\Models\FormFieldResult', 'form_resultable', 'target_table', 'target_id');
    }

    /**
     * @return mixed
     */
    public function getActionDoFormResultsAttribute()
    {
        $form_id = $this->action_do_form_id;
        return $this->form_results()
            ->where('type', 'do')
            ->with('form_field.form')
            ->whereHas('form_field', function($q) use ($form_id) { $q->whereHas('form', function($q2) use ($form_id) { $q2->where('id', $form_id); }); })
            ->get();
    }

    /**
     * @return mixed
     */
    public function getActionTransferFormResultsAttribute()
    {
        $form_id = $this->action_transfer_form_id;
        return $this->form_results()
            ->where('type', 'transfer')
            ->with('form_field.form')
            ->whereHas('form_field', function($q) use ($form_id) { $q->whereHas('form', function($q2) use ($form_id) { $q2->where('id', $form_id); }); })
            ->get();
    }

    /**
     * @return mixed
     */
    public function getActionRejectFormResultsAttribute()
    {
        $form_id = $this->action_reject_form_id;
        return $this->form_results()
            ->where('type', 'reject')
            ->with('form_field.form')
            ->whereHas('form_field', function($q) use ($form_id) { $q->whereHas('form', function($q2) use ($form_id) { $q2->where('id', $form_id); }); })
            ->get();
    }

    /**
     * @return mixed
     */
    public function getAssignerPriorityAttribute()
    {
        return $this->task->priority()->where('user_id', $this->assigner_id)->first();
    }

    /**
     * @return mixed
     */
    public function getEmployeePriorityAttribute()
    {
        $r = $this->task->priority()->where('user_id', $this->employee_id)->first();
        return $r ? $r : $this->assigner_priority;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function visits()
    {
        return $this->morphMany('Hamahang\LVS\Models\Visit', 'visitable', 'target_type', 'target_id');
    }

    /**
     * @return bool
     */
    public function getVisitedAttribute()
    {
        return $this->visits->where('user_id', auth()->id())->where('target_id', $this->id)->count() ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('Hamahang\LTM\Models\Tasks\TaskStatus', 'task_assignment_id', 'id')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCurrentStatusAttribute()
    {
        $res = TaskStatus::whereHas('assignment', function($query) {
            $query->where('task_id', $this->task_id);
        })
        ->orderBy('id', 'desc');
        return $res ? $res->first() : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function confirmation()
    {
        return $this->hasOne('Hamahang\LTM\Models\Tasks\TaskConfirmation', 'task_assignment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function previous_assignment()
    {
        return $this->hasOne('Hamahang\LTM\Models\Tasks\TaskAssignment', 'id', 'previous_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function next_assignment()
    {
        return $this->hasOne('Hamahang\LTM\Models\Tasks\TaskAssignment', 'previous_id', 'id');
    }
}
