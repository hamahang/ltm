<?php
if (!function_exists('ltm_array_field_name'))
{
    function ltm_array_field_name($key)
    {
        $key_name_parts = explode('.', $key);
        $res = $key_name_parts[0];
        foreach ($key_name_parts as $k => $part)
        {
            if ($k > 0)
            {
                $res .= '[' . $part . ']';
            }
        }
        return $res;
    }
}
if (!function_exists('ltm_validation_error_to_api_json'))
{
    function ltm_validation_error_to_api_json($errors)
    {
        $api_errors = [];
        foreach ($errors->getMessages() as $key => $value)
        {
            $key = ltm_array_field_name($key);
            $api_errors[$key] = array_values($value);
        }
        return $api_errors;
    }
}
?>
