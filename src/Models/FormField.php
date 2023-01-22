<?php

namespace Hamahang\LTM\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    /**
     * @var string
     */
    protected $table = 'ltm_form_fields';

    /**
     * @var array
     */
    private $templates_search =
    [
        '[field_class]',
        '[field_id]',
        '[field_name]',
        '[field_title]',
        '[field_placeholder]',
        '[field_value]',
        '[field_style]',
        '[field_attributes]',
    ];

    /**
     * Form constructor.
     * @param array $attributes
     */
    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    /**
     * @param object $attributes
     * @return array
     */
    function templates_replace(object $attributes)
    {
        $r =
        [
            $attributes->field_class,
            $attributes->field_id,
            $attributes->field_name,
            $attributes->field_title,
            $attributes->field_placeholder,
            $attributes->field_style,
            $attributes->field_value,
            $attributes->field_attributes,
        ];
        return $r;
    }

    /**
     * @param $class
     * @param $for
     * @param $title
     * @return string
     */
    function generate_field_label($title, $for = null, $class = null)
    {
        return "<label class=\"form-label $class\" for=\"$for\">$title</label>";
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_checkbox(object $attributes)
    {
        $t = '<input type="checkbox" class="[field_class]" id="[field_id]" name="[field_name]" placeholder="[field_placeholder]" value="[field_value]" [field_style] [field_attributes] />';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_file(object $attributes)
    {
        $t = '<input type="file" class="[field_class]" id="[field_id]" name="[field_name]" placeholder="[field_placeholder]" value="[field_value]" [field_style] [field_attributes] />';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_label(object $attributes)
    {
        $t = '<label class="[field_class]" id="[field_id]" [field_style] [field_attributes] />';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_lfm(object $attributes)
    {
        $encoded_id = ltm_encode_ids([$attributes->id], 8);
        $setting = json_decode($attributes->setting, true);
        $options = [];
        if (isset($setting['max_file_number'])) { $options['max_file_number'] = $setting['max_file_number']; }
        if (isset($setting['min_file_number'])) { $options['min_file_number'] = $setting['min_file_number']; }
        if (isset($setting['show_file_uploaded'])) { $options['show_file_uploaded'] = $setting['show_file_uploaded']; }
        if (isset($setting['size_file'])) { $options['size_file'] = $setting['size_file']; }
        if (isset($setting['path'])) { $options['path'] = $setting['path']; }
        if (isset($setting['true_file_extension'])) { $options['true_file_extension'] = $setting['true_file_extension']; }
        $section = 'lfm_' . $attributes->field_id;
        $lfm = LFM_CreateModalFileManager($section, $options, 'insert', $setting['callback'], null, null, null, 'انتخاب فایل/ها');
        return $lfm['button'] . $lfm['modal_content'] . "<div id=\"" . $section . "_result\"></div><script>function " . $setting['callback'] . "(result) { $('#" . $section . "_result').html(result." . $section . ".view.small); }</script>";
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_radio(object $attributes)
    {
        $t = '<input type="radio" class="[field_class]" id="[field_id]" name="[field_name]" placeholder="[field_placeholder]" value="[field_value]" [field_style] [field_attributes] />';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_select(object $attributes)
    {
        $t = '<select class="form-control [field_class]" id="[field_id]" name="[field_name]" [field_style] [field_attributes]></select>';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_text(object $attributes)
    {
        $t = '<input type="text" class="form-control [field_class]" id="[field_id]" name="[field_name]" placeholder="[field_placeholder]" value="[field_value]" [field_style] [field_attributes] />';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @param object $attributes
     * @return mixed
     */
    function generate_textarea(object $attributes)
    {
        $t = '<textarea class="form-control [field_class]" id="[field_id]" name="[field_name]" placeholder="[field_placeholder]" [field_style] [field_attributes]>[field_value]</textarea>';
        return str_replace($this->templates_search, $this->templates_replace($attributes), $t);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo('Hamahang\LTM\Models\Form');
    }
}
