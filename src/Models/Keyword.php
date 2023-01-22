<?php

namespace Hamahang\LTM\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'ltm_keywords';

    public function tasks()
    {
        return $this->morphedByMany('Hamahang\LTM\Models\Tasks\Task', 'target', 'ltm_keywordables', 'keyword_id', 'target_id');
    }

}
