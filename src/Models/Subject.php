<?php

namespace Hamahang\LTM\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'ltm_subjects';

    //
    public function user()
    {
        return $this->belongsTo(config('laravel_task_manager.user_model'), 'created_by');
    }

    public function parent()
    {
        return $this->hasOne('Hamahang\LTM\Models\Subject', 'id', 'parent_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return ltm_Date_GtoJ($value, 'Y-m-d');
    }

}
