<?php

namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTranscript extends Model
{
    /**
     *
     */
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'ltm_task_transcripts';

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends =
    [
        'type_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laravel_task_manager.user_model'), 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getTypeNameAttribute()
    {
        return config("tasks.transcripts.$this->type");
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
}
