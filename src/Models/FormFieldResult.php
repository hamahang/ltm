<?php

namespace Hamahang\LTM\Models;

use Illuminate\Database\Eloquent\Model;

class FormFieldResult extends Model
{
    /**
     * @var string
     */
    protected $table = 'ltm_form_field_results';

    /**
     * @param $rows
     */
    public static function store(array $rows)
    {
        foreach ($rows as $row)
        {
            $form_field_result = new FormFieldResult;
            $form_field_result->form_field_id = $row['form_field_id'];
            $form_field_result->target_table = $row['target_table'];
            $form_field_result->target_id = $row['target_id'];
            $form_field_result->type = $row['type'];
            $form_field_result->value = $row['value'];
            $form_field_result->save();
        }
    }

    public function form_field()
    {
        return $this->belongsTo('Hamahang\LTM\Models\FormField', 'form_field_id', 'id');
    }

    public function form_resultable()
    {
        return $this->morphTo();
    }
}
