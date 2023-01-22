<?php

namespace Hamahang\LTM\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * @var string
     */
    protected $table = 'ltm_forms';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function fields()
    {
        return $this->hasMany('Hamahang\LTM\Models\FormField', 'form_id', 'id');
    }

    /**
     * @param null $form_id
     * @param null $additional_randomization_phrase
     * @return string
     */
    public static function generate_fields_code($form_id = null, $additional_randomization_phrase = null)
    {
        $data = microtime() . rand(100000, 999999) . rand(100000, 999999) . $additional_randomization_phrase;
        $suffix = $form_id ? '_f' . $form_id : null;
        $r = hash('crc32', $data) . $suffix;
        return $r;
    }

    /**
     * @param $form_id
     * @param null $system_field_prefix
     * @param bool $generate_labels
     * @return array
     */
    public static function generate_fields($form_id, $system_field_prefix, $generate_labels = true)
    {
        $r = [];
        $random = hash('crc32', microtime() . rand(100000, 999999) . rand(100000, 999999));
        $form = Form::find($form_id);
        if ($form)
        {
            $fields = $form->fields;
            foreach ($fields as $field)
            {
                //add system methods
                $field->system_field_prefix = $system_field_prefix ? : $random . '_f' . $field->form_id;
                //change fields
                $field->field_id_original = $field->field_id;
                $field->field_id = $field->system_field_prefix . '_' . $field->field_id;
                $field->system_id_encoded = ltm_encode_ids([$field->id], 8);
                $field->field_name_original = $field->field_name;
                $field->field_name = $field->system_field_prefix . '[' . $field->system_id_encoded . '_' . $field->field_name . ']';
                $method = 'generate_' . $field->type;
                $form_field = new FormField();
                $generated_field = $form_field->$method($field);
                if ($generate_labels)
                {
                    $r[$form_field->generate_field_label($field->label_title, $field->field_id, $field->label_class)] = $generated_field;
                } else
                {
                    $r[] = $generated_field;
                }
            }
        }
        return $r;
    }

}
